<?php

namespace App\Component\Settings\Application\Mapper;

use App\Component\Settings\Data\Entity\Setting;
use App\Component\Settings\Presentation\ViewModel\SettingViewModel;

interface SettingMapperInterface
{
    public function toViewModel(Setting $setting): SettingViewModel;
    
    public function toViewModelCollection(array $settings): array;
} 