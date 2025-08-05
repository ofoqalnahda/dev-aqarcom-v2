<?php

namespace App\Component\Settings\Application\Mapper;

use App\Component\Settings\Data\Entity\ProfitSubscriber;
use App\Component\Settings\Presentation\ViewModel\ProfitSubscriberViewModel;
use Illuminate\Database\Eloquent\Collection;

interface ProfitSubscriberMapperInterface
{
    public function toViewModel(ProfitSubscriber $subscriber): ProfitSubscriberViewModel;
    
    public function toViewModelCollection(Collection $subscribers): array;
} 