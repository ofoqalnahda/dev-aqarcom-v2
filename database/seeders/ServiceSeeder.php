<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Component\Properties\Data\Entity\Service\Service;
use App\Component\Properties\Domain\Enum\ServiceTypeEnum;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'type' => ServiceTypeEnum::REAL_ESTATE_SERVICES,
                'name' => 'Property Valuation',
                'is_active' => true,
            ],
            [
                'type' => ServiceTypeEnum::REAL_ESTATE_SERVICES,
                'name' => 'Property Management',
                'is_active' => true,
            ],
            [
                'type' => ServiceTypeEnum::REAL_ESTATE_SERVICES,
                'name' => 'Real Estate Investment',
                'is_active' => true,
            ],
            [
                'type' => ServiceTypeEnum::SUPPORT_SERVICES,
                'name' => 'Legal Consultation',
                'is_active' => true,
            ],
            [
                'type' => ServiceTypeEnum::SUPPORT_SERVICES,
                'name' => 'Financial Advisory',
                'is_active' => true,
            ],
            [
                'type' => ServiceTypeEnum::SUPPORT_SERVICES,
                'name' => 'Insurance Services',
                'is_active' => true,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }
    }
}



