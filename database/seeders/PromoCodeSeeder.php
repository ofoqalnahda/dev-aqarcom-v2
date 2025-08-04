<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Component\Payments\Domain\Entity\PromoCode;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promoCodes = [
            [
                'code' => 'WELCOME50',
                'description' => 'Welcome discount - 50% off for new users',
                'discount_type' => 'percentage',
                'discount_value' => 50.00,
                'minimum_amount' => 100.00,
                'maximum_discount' => 500.00,
                'usage_limit' => 100,
                'used_count' => 0,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(6),
                'is_active' => true,
                'applicable_packages' => null, // All packages
            ],
            [
                'code' => 'SAVE100',
                'description' => 'Fixed discount of 100 SAR',
                'discount_type' => 'fixed_amount',
                'discount_value' => 100.00,
                'minimum_amount' => 200.00,
                'maximum_discount' => 100.00,
                'usage_limit' => 50,
                'used_count' => 0,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(3),
                'is_active' => true,
                'applicable_packages' => null, // All packages
            ],
            [
                'code' => 'FREEPACKAGE',
                'description' => 'Get 3-month package for free',
                'discount_type' => 'percentage',
                'discount_value' => 100.00,
                'minimum_amount' => 0.00,
                'maximum_discount' => null,
                'usage_limit' => 10,
                'used_count' => 0,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(1),
                'is_active' => true,
                'applicable_packages' => [1], // Only for package ID 1 (3-month package)
            ],
        ];

        foreach ($promoCodes as $promoCode) {
            PromoCode::create($promoCode);
        }
    }
} 