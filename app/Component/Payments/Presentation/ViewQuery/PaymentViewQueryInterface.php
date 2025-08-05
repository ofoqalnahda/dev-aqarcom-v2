<?php

namespace App\Component\Payments\Presentation\ViewQuery;

interface PaymentViewQueryInterface
{
    /**
     * Get user subscriptions as ViewModels
     * @param int $userId
     * @return array
     */
    public function getUserSubscriptions(int $userId): array;
} 