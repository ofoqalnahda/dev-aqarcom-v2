<?php

namespace App\Component\Payments\Infrastructure\ViewQuery;

use App\Component\Payments\Presentation\ViewQuery\PaymentViewQueryInterface;
use App\Component\Payments\Application\Service\PaymentServiceInterface;
use App\Component\Payments\Application\Mapper\PaymentMapperInterface;

class PaymentViewQuery implements PaymentViewQueryInterface
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

    public function getUserSubscriptions(int $userId): array
    {
        $subscriptions = $this->paymentService->getUserSubscriptions($userId);
        return $this->paymentMapper->toSubscriptionViewModelCollection($subscriptions);
    }
} 