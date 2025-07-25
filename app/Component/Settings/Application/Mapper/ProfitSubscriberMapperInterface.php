<?php

namespace App\Component\Settings\Application\Mapper;

use App\Component\Settings\Data\Entity\ProfitSubscriber;
use App\Component\Settings\Presentation\ViewModel\ProfitSubscriberViewModel;

interface ProfitSubscriberMapperInterface
{
    public function toViewModel(ProfitSubscriber $subscriber): ProfitSubscriberViewModel;
    
    public function toViewModelCollection(array $subscribers): array;
} 