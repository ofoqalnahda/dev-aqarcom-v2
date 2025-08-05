<?php

namespace App\Component\Payments\Infrastructure\Service;

use App\Component\Payments\Application\Service\PaymentServiceInterface;
use App\Component\Payments\Application\Repository\PromoCodeRepositoryInterface;
use App\Component\Payments\Application\Repository\SubscriptionRepositoryInterface;
use App\Component\Settings\Application\Service\PackageServiceInterface;
use App\Component\Payments\Domain\Dto\PromoCodeCalculationDto;
use App\Component\Payments\Domain\Dto\SubscriptionDto;
use App\Component\Payments\Domain\Exception\InvalidPromoCodeException;
use App\Component\Payments\Domain\Enum\PaymentStatus;
use App\Component\Payments\Domain\Enum\SubscriptionStatus;
use Carbon\Carbon;

class PaymentService implements PaymentServiceInterface
{
    public function __construct(
        private PromoCodeRepositoryInterface $promoCodeRepository,
        private SubscriptionRepositoryInterface $subscriptionRepository,
        private PackageServiceInterface $packageService
    ) {}

    public function calculatePromoCode(int $packageId, string $promoCode): PromoCodeCalculationDto
    {
        $package = $this->packageService->getPackage($packageId);
        
        if (!$package) {
            return PromoCodeCalculationDto::createInvalid(
                $packageId,
                0,
                'Package not found'
            );
        }

        $originalPrice = (float) $package->price;
        
        if (empty($promoCode)) {
            return PromoCodeCalculationDto::createValid(
                $packageId,
                $originalPrice,
                $originalPrice,
                0,
                0
            );
        }

        $promoCodeEntity = $this->promoCodeRepository->findActiveByCode($promoCode);
        
        if (!$promoCodeEntity) {
            return PromoCodeCalculationDto::createInvalid(
                $packageId,
                $originalPrice,
                'Promo code not found'
            );
        }

        try {
            $this->validatePromoCode($promoCodeEntity, $packageId, $originalPrice);
        } catch (InvalidPromoCodeException $e) {
            return PromoCodeCalculationDto::createInvalid(
                $packageId,
                $originalPrice,
                $e->getMessage()
            );
        }

        $discountAmount = $promoCodeEntity->calculateDiscount($originalPrice);
        $finalPrice = $originalPrice - $discountAmount;
        $discountPercentage = $originalPrice > 0 ? ($discountAmount / $originalPrice) * 100 : 0;

        return PromoCodeCalculationDto::createValid(
            $packageId,
            $originalPrice,
            $finalPrice,
            $discountAmount,
            $discountPercentage,
            $promoCode
        );
    }

    public function createSubscription(SubscriptionDto $subscriptionDto): array
    {
        $subscription = $this->subscriptionRepository->create([
            'user_id' => $subscriptionDto->userId,
            'package_id' => $subscriptionDto->packageId,
            'promo_code_id' => $subscriptionDto->promoCodeId,
            'original_price' => $subscriptionDto->originalPrice,
            'final_price' => $subscriptionDto->finalPrice,
            'discount_amount' => $subscriptionDto->discountAmount,
            'discount_percentage' => $subscriptionDto->discountPercentage,
            'payment_method' => $subscriptionDto->paymentMethod->value,
            'payment_status' => $subscriptionDto->paymentStatus->value,
            'subscription_status' => $subscriptionDto->subscriptionStatus->value,
            'start_date' => now(),
            'end_date' => $this->calculateEndDate($subscriptionDto->packageId),
            'transaction_id' => $subscriptionDto->transactionId,
            'payment_details' => $subscriptionDto->paymentDetails,
        ]);

        // Increment promo code usage if used
        if ($subscriptionDto->promoCodeId) {
            $promoCode = $this->promoCodeRepository->findById($subscriptionDto->promoCodeId);
            if ($promoCode) {
                $this->promoCodeRepository->incrementUsageCount($promoCode);
            }
        }

        return $subscription->toArray();
    }

    public function processPayment(int $subscriptionId, array $paymentDetails): array
    {
        $subscription = $this->subscriptionRepository->findById($subscriptionId);
        
        if (!$subscription) {
            throw new \Exception('Subscription not found');
        }

        // Update payment status and details
        $updatedSubscription = $this->subscriptionRepository->update($subscription, [
            'payment_status' => PaymentStatus::COMPLETED->value,
            'subscription_status' => SubscriptionStatus::ACTIVE->value,
            'payment_details' => array_merge($subscription->payment_details ?? [], $paymentDetails),
        ]);

        return $updatedSubscription->toArray();
    }

    public function getSubscription(int $subscriptionId): ?array
    {
        $subscription = $this->subscriptionRepository->findById($subscriptionId);
        return $subscription ? $subscription->toArray() : null;
    }

    public function getUserSubscriptions(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->subscriptionRepository->findByUserId($userId);
    }

    public function getPromoCodeByCode(string $code): ?array
    {
        $promoCode = $this->promoCodeRepository->findActiveByCode($code);
        return $promoCode ? $promoCode->toArray() : null;
    }

    private function validatePromoCode($promoCode, int $packageId, float $originalPrice): void
    {
        if (!$promoCode->canBeUsed()) {
            if ($promoCode->isExpired()) {
                throw InvalidPromoCodeException::codeExpired($promoCode->code);
            }
            if ($promoCode->isUsageLimitReached()) {
                throw InvalidPromoCodeException::codeUsageLimitReached($promoCode->code);
            }
            throw InvalidPromoCodeException::codeInactive($promoCode->code);
        }

        if ($promoCode->minimum_amount && $originalPrice < $promoCode->minimum_amount) {
            throw InvalidPromoCodeException::minimumAmountNotMet($promoCode->code, $promoCode->minimum_amount);
        }

        if ($promoCode->applicable_packages && !in_array($packageId, $promoCode->applicable_packages)) {
            throw InvalidPromoCodeException::notApplicableToPackage($promoCode->code, $packageId);
        }
    }

    private function calculateEndDate(int $packageId): Carbon
    {
        $package = $this->packageService->getPackage($packageId);
        $periodMonths = $package ? $package->period_months : 1;
        
        return now()->addMonths($periodMonths);
    }
} 