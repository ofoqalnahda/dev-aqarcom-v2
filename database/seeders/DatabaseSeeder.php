<?php

namespace Database\Seeders;

use App\Component\Ad\Data\Entity\Ad\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed packages
        $this->call(PackageSeeder::class);
        
        // Seed promo codes
        $this->call(PromoCodeSeeder::class);
    }
}
