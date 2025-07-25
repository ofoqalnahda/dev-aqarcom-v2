<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Component\Settings\Data\Entity\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Individual Packages (باقات الأفراد)
        Package::create([
            'name' => 'باقة 3 شهور',
            'type' => 'individual',
            'period_months' => 3,
            'description' => 'باقة مثالية للمبتدئين',
            'price' => 190.00,
            'price_before_discount' => 375.00,
            'features' => [
                'احصل على 50 إعلان مجاناً',
                'عدد الإعلانات المميزة: 1 إعلان مجاني',
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Package::create([
            'name' => 'باقة 6 شهور',
            'type' => 'individual',
            'period_months' => 6,
            'description' => 'الباقة الأكثر شعبية',
            'price' => 400.00,
            'price_before_discount' => 750.00,
            'features' => [
                'احصل على 100 إعلان مجاناً',
                'عدد الإعلانات المميزة: 3 إعلان مجاني',
            ],
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Package::create([
            'name' => 'باقة 12 شهور',
            'type' => 'individual',
            'period_months' => 12,
            'description' => 'أفضل قيمة للمال',
            'price' => 750.00,
            'price_before_discount' => 1500.00,
            'features' => [
                'احصل على 150 إعلان مجاناً',
                'عدد الإعلانات المميزة: 5 إعلان مجاني',
            ],
            'is_active' => true,
            'sort_order' => 3,
        ]);

        // Company Packages (باقات الشركات)
        Package::create([
            'name' => 'باقة الشركات 3 شهور',
            'type' => 'companies',
            'period_months' => 3,
            'description' => 'حلول متكاملة للشركات الناشئة',
            'price' => 1200.00,
            'price_before_discount' => 1800.00,
            'features' => [
                'إعلانات غير محدودة',
                'دعم فني متخصص',
                'تقارير مفصلة',
                'أولوية في النتائج',
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Package::create([
            'name' => 'باقة الشركات 6 شهور',
            'type' => 'companies',
            'period_months' => 6,
            'description' => 'الحل الأمثل للشركات المتوسطة',
            'price' => 2200.00,
            'price_before_discount' => 3600.00,
            'features' => [
                'إعلانات غير محدودة',
                'دعم فني متخصص على مدار الساعة',
                'تقارير تحليلية متقدمة',
                'أولوية عالية في النتائج',
                'استشارات تسويقية مجانية',
            ],
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Package::create([
            'name' => 'باقة الشركات 12 شهور',
            'type' => 'companies',
            'period_months' => 12,
            'description' => 'الحل الشامل للشركات الكبيرة',
            'price' => 4000.00,
            'price_before_discount' => 7200.00,
            'features' => [
                'إعلانات غير محدودة',
                'مدير حساب مخصص',
                'تقارير مخصصة وتحليلات متقدمة',
                'أولوية قصوى في النتائج',
                'استشارات تسويقية شهرية',
                'دعم تقني متميز',
                'تدريب فريق العمل',
            ],
            'is_active' => true,
            'sort_order' => 3,
        ]);
    }
}
