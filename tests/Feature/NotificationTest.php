<?php

namespace Tests\Feature;

use App\Component\Notification\Data\Entity\Notification\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_notifications()
    {
        $user = User::factory()->create();
        $notifications = Notification::factory()->count(5)->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/v1/notifications');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'items' => [
                        '*' => [
                            'id',
                            'message',
                            'is_read',
                            'read_at',
                            'created_at',
                            'updated_at'
                        ]
                    ],
                    'meta' => [
                        'current_page',
                        'per_page',
                        'total',
                        'last_page'
                    ]
                ]
            ]);
    }

    public function test_user_can_mark_notification_as_read()
    {
        $user = User::factory()->create();
        $notification = Notification::factory()->create([
            'user_id' => $user->id,
            'is_read' => false
        ]);

        $response = $this->actingAs($user)
            ->postJson("/api/v1/notifications/{$notification->id}/mark-as-read");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Notification marked as read successfully'
            ]);

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'is_read' => true
        ]);
    }

    public function test_user_can_mark_all_notifications_as_read()
    {
        $user = User::factory()->create();
        $notifications = Notification::factory()->count(3)->unread()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/v1/notifications/mark-all-as-read');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'marked_count' => 3
                ]
            ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'is_read' => true
        ]);
    }

    public function test_user_cannot_access_other_users_notifications()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $notification = Notification::factory()->create([
            'user_id' => $user2->id
        ]);

        $response = $this->actingAs($user1)
            ->postJson("/api/v1/notifications/{$notification->id}/mark-as-read");

        $response->assertStatus(404);
    }
}
