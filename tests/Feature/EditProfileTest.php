<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Component\Properties\Data\Entity\Service\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Artisan;

class EditProfileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Explicitly run migrations for SQLite in-memory database
        if (config('database.default') === 'sqlite' && config('database.connections.sqlite.database') === ':memory:') {
            Artisan::call('migrate');
        }
    }

    public function test_user_can_update_profile_with_new_fields()
    {
        // Create a user
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        // Create some services
        $service1 = Service::create([
            'type' => 'real_estate_services',
            'name' => 'Property Management',
            'is_active' => true
        ]);

        $service2 = Service::create([
            'type' => 'support_services',
            'name' => 'Legal Consultation',
            'is_active' => true
        ]);

        $profileData = [
            'name' => 'John Doe',
            'about_company' => 'We are a leading real estate company',
            'working_hours' => [
                [
                    'day' => 'monday',
                    'start_time' => '09:00',
                    'end_time' => '17:00',
                    'is_working_day' => true
                ],
                [
                    'day' => 'tuesday',
                    'start_time' => '09:00',
                    'end_time' => '17:00',
                    'is_working_day' => true
                ]
            ],
            'previous_work_history' => [
                [
                    'company_name' => 'Previous Company',
                    'description' => 'Worked as a real estate agent',
                    'start_date' => '2020-01-01',
                    'end_date' => '2022-12-31',
                    'is_current_job' => false
                ]
            ],
            'services' => [$service1->id, $service2->id]
        ];

        $response = $this->postJson('/api/v1/auth/edit-profile', $profileData);

        $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Profile updated'
                ]);

        // Refresh user and check relationships
        $user->refresh();
        
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('We are a leading real estate company', $user->about_company);
        $this->assertCount(2, $user->workingHours);
        $this->assertCount(1, $user->previousWorkHistory);
        $this->assertCount(2, $user->services);
    }

    public function test_working_hours_validation()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $invalidData = [
            'working_hours' => [
                [
                    'day' => 'invalid_day',
                    'start_time' => '25:00'
                ]
            ]
        ];

        $response = $this->postJson('/api/v1/auth/edit-profile', $invalidData);

        $response->assertStatus(422);
    }
}
