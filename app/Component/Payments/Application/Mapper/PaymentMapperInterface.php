<?php

namespace App\Component\Payments\Application\Mapper;

use App\Component\Payments\Domain\Entity\Subscription;
use App\Component\Payments\Domain\Entity\PromoCode;
use App\Component\Payments\Presentation\ViewModel\SubscriptionViewModel;
use App\Component\Payments\Presentation\ViewModel\PromoCodeViewModel;

interface PaymentMapperInterface
{
    public function toSubscriptionViewModel(Subscription $subscription): SubscriptionViewModel;
    
    public function toSubscriptionViewModelCollection(\Illuminate\Database\Eloquent\Collection $subscriptions): array;
    
    public function toPromoCodeViewModel(PromoCode $promoCode): PromoCodeViewModel;
} 