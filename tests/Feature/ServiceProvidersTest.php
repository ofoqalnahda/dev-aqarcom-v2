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
                        'total_ratings',
                        'distance'
                    ]
                ],
                'pagination'
            ]);

        // Should only return office users (not individuals)
        $this->assertCount(2, $response->json('data'));
        $this->assertEquals('Construction Company', $response->json('data.0.name'));
        $this->assertEquals('Real Estate Agency', $response->json('data.1.name'));
        
        // Distance should be 0 when no coordinates provided
        $this->assertEquals(0, $response->json('data.0.distance'));
        $this->assertEquals(0, $response->json('data.1.distance'));
    }

    public function test_can_list_service_providers_with_distance_calculation()
    {
        // Create service providers with coordinates
        User::factory()->create([
            'name' => 'Near Company',
            'user_type' => 'office',
            'latitude' => 21.422510,
            'longitude' => 39.826168
        ]);

        User::factory()->create([
            'name' => 'Far Company',
            'user_type' => 'office',
            'latitude' => 21.422510,
            'longitude' => 39.826168
        ]);

        // Test with user coordinates
        $response = $this->getJson('/api/v1/service-providers?latitude=21.422510&longitude=39.826168');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'user_type',
                        'distance'
                    ]
                ],
                'pagination'
            ]);

        $this->assertCount(2, $response->json('data'));
        
        // Distance should be calculated (very close to 0 for same coordinates)
        $this->assertLessThan(1, $response->json('data.0.distance'));
        $this->assertLessThan(1, $response->json('data.1.distance'));
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
        $this->assertArrayHasKey('distance', $response->json('data.0'));
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
                    'ratings_received',
                    'distance'
                ]
            ]);

        $this->assertEquals('Construction Company', $response->json('data.name'));
        $this->assertEquals('We build amazing structures', $response->json('data.about_company'));
        $this->assertEquals(0, $response->json('data.distance'));
    }

    public function test_can_get_service_provider_details_with_distance()
    {
        $serviceProvider = User::factory()->create([
            'name' => 'Construction Company',
            'user_type' => 'office',
            'latitude' => 21.422510,
            'longitude' => 39.826168
        ]);

        $response = $this->getJson("/api/v1/service-providers/{$serviceProvider->id}?latitude=21.422510&longitude=39.826168");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'name',
                    'user_type',
                    'distance'
                ]
            ]);

        $this->assertEquals('Construction Company', $response->json('data.name'));
        $this->assertLessThan(1, $response->json('data.distance'));
    }

    public function test_cannot_get_individual_user_as_service_provider()
    {
        $individual = User::factory()->create([
            'name' => 'John Doe',
            'user_type' => 'individual'
        ]);

        $response = $this->getJson("/api/v1/service-providers/{$individual->id}");

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Service provider not found'
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
