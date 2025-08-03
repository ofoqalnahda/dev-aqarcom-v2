<?php

namespace App\Component\Settings\Infrastructure\Mapper;

use App\Component\Settings\Application\Mapper\ProfitSubscriberMapperInterface;
use App\Component\Settings\Data\Entity\ProfitSubscriber;
use App\Component\Settings\Presentation\ViewModel\ProfitSubscriberViewModel;

class ProfitSubscriberMapper implements ProfitSubscriberMapperInterface
{
    public function toViewModel(ProfitSubscriber $subscriber): ProfitSubscriberViewModel
    {
        return new ProfitSubscriberViewModel($subscriber);
    }
    
    public function toViewModelCollection(array $subscribers): array
    {
        return array_map(function ($subscriber) {
            return $this->toViewModel($subscriber);
        }, $subscribers);
    }
} 