<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceProvidersTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_service_providers()
    {
        // Create some test users
        User::factory()->create([
            'name' => 'Construction Company',
            'user_type' => 'office',
            'image' => 'construction.jpg'
        ]);

        User::factory()->create([
            'name' => 'Real Estate Agency',
            'user_type' => 'office',
            'image' => 'realestate.jpg'
        ]);

        User::factory()->create([
            'name' => 'John Doe',
            'user_type' => 'individual',
            'image' => 'john.jpg'
        ]);

        $response = $this->getJson('/api/v1/service-providers');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'image',
                        'user_type',
                        'average_rating',
                        'total_ratings'
                    ]
                ],
                'pagination'
            ]);

        // Should only return office users (not individuals)
        $this->assertCount(2, $response->json('data'));
        $this->assertEquals('Construction Company', $response->json('data.0.name'));
        $this->assertEquals('Real Estate Agency', $response->json('data.1.name'));
    }

    public function test_can_search_service_providers()
    {
        User::factory()->create([
            'name' => 'Construction Company',
            'user_type' => 'office'
        ]);

        User::factory()->create([
            'name' => 'Real Estate Agency',
            'user_type' => 'office'
        ]);

        $response = $this->getJson('/api/v1/service-providers?search=construction');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('Construction Company', $response->json('data.0.name'));
    }

    public function test_can_get_service_provider_details()
    {
        $serviceProvider = User::factory()->create([
            'name' => 'Construction Company',
            'user_type' => 'office',
            'about_company' => 'We build amazing structures'
        ]);

        $response = $this->getJson("/api/v1/service-providers/{$serviceProvider->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'name',
                    'user_type',
                    'about_company',
                    'rating_stats',
                    'ratings_received'
                ]
            ]);

        $this->assertEquals('Construction Company', $response->json('data.name'));
        $this->assertEquals('We build amazing structures', $response->json('data.about_company'));
    }

    public function test_cannot_get_individual_user_as_service_provider()
    {
        $individual = User::factory()->create([
            'name' => 'John Doe',
            'user_type' => 'individual'
        ]);

        $response = $this->getJson("/api/v1/service-providers/{$individual->id}");

        $response->assertStatus(400)
            ->assertJson([
                'status' => 'error',
                'message' => 'User is not a service provider'
            ]);
    }

    public function test_returns_404_for_nonexistent_service_provider()
    {
        $response = $this->getJson('/api/v1/service-providers/999');

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Service provider not found'
            ]);
    }
}
