<?php

namespace App\Component\Payments\Infrastructure\Http\Handler;

use App\Component\Payments\Application\Service\PaymentServiceInterface;
use App\Component\Payments\Application\Mapper\PaymentMapperInterface;
use App\Component\Payments\Domain\Dto\SubscriptionDto;
use App\Component\Payments\Domain\Enum\PaymentMethod;
use App\Component\Payments\Domain\Enum\PaymentStatus;
use App\Component\Payments\Domain\Enum\SubscriptionStatus;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/payments/subscribe',
    tags: ['Payments'],
    security: [['bearerAuth' => []]],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['package_id', 'payment_method'],
            properties: [
                new OA\Property(property: 'package_id', type: 'integer', description: 'Package ID'),
                new OA\Property(property: 'promo_code', type: 'string', description: 'Promo code (optional)'),
                new OA\Property(property: 'payment_method', type: 'string', enum: ['electronic', 'bank', 'credit_card', 'debit_card', 'wallet']),
                new OA\Property(property: 'payment_details', type: 'object', description: 'Additional payment details'),
            ],
            type: 'object'
        )
    ),
    responses: [
        new OA\Response(response: 200, description: 'Subscription created successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', properties: [
                    new OA\Property(property: 'subscription', ref: '#/components/schemas/SubscriptionViewModel'),
                ], type: 'object'),
            ],
            type: 'object'
        )),
        new OA\Response(response: 400, description: 'Invalid request'),
        new OA\Response(response: 401, description: 'Unauthorized'),
        new OA\Response(response: 422, description: 'Validation error'),
    ]
)]
class SubscribeToPackageHandler extends Handler
{
    protected PaymentServiceInterface $paymentService;
    protected PaymentMapperInterface $paymentMapper;

    public function __construct(
        PaymentServiceInterface $paymentService,
        PaymentMapperInterface $paymentMapper
    ) {
        $this->paymentService = $paymentService;
        $this->paymentMapper = $paymentMapper;
    }

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'package_id' => 'required|integer|exists:packages,id',
            'promo_code' => 'nullable|string|max:50',
            'payment_method' => 'required|string|in:electronic,bank,credit_card,debit_card,wallet',
            'payment_details' => 'nullable|array',
        ]);

        $userId = auth()->id();
        $packageId = $request->input('package_id');
        $promoCode = $request->input('promo_code');
        $paymentMethod = PaymentMethod::from($request->input('payment_method'));
        $paymentDetails = $request->input('payment_details', []);

        // Calculate final price with promo code
        $calculation = $this->paymentService->calculatePromoCode($packageId, $promoCode ?? '');
        
        if (!$calculation->isValid && !empty($promoCode)) {
            return response()->json([
                'status' => 'error',
                'message' => $calculation->errorMessage,
            ], 422);
        }

        // Get promo code ID if promo code is valid
        $promoCodeId = null;
        if ($calculation->promoCode && $calculation->isValid) {
            $promoCodeEntity = $this->paymentService->getPromoCodeByCode($calculation->promoCode);
            $promoCodeId = $promoCodeEntity ? $promoCodeEntity['id'] : null;
        }

        // Create subscription DTO
        $subscriptionDto = new SubscriptionDto(
            userId: $userId,
            packageId: $packageId,
            promoCodeId: $promoCodeId,
            originalPrice: $calculation->originalPrice,
            finalPrice: $calculation->finalPrice,
            discountAmount: $calculation->discountAmount,
            discountPercentage: $calculation->discountPercentage,
            paymentMethod: $paymentMethod,
            paymentStatus: PaymentStatus::PENDING,
            subscriptionStatus: SubscriptionStatus::ACTIVE,
            paymentDetails: $paymentDetails,
        );

        // Create subscription
        $subscriptionData = $this->paymentService->createSubscription($subscriptionDto);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription created successfully',
            'data' => [
                'subscription' => $subscriptionData,
            ],
        ]);
    }


} 