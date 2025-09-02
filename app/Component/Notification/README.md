# Notification Component

This component handles user notifications in the application following Domain-Driven Design (DDD) principles.

## Structure

```
app/Component/Notification/
├── Application/           # Application layer (business logic)
│   ├── Mapper/           # Data mapping interfaces
│   ├── Repository/       # Data access interfaces
│   └── Service/          # Business logic interfaces
├── Data/                  # Data layer
│   └── Entity/           # Eloquent models
├── Domain/               # Domain layer
│   └── Enum/            # Domain enums
├── Infrastructure/       # Infrastructure layer
│   ├── Http/            # HTTP handlers and requests
│   ├── Mapper/          # Data mapping implementations
│   ├── Repository/      # Data access implementations
│   ├── Service/         # Business logic implementations
│   ├── ServiceProvider/ # Dependency injection
│   └── ViewQuery/       # View query implementations
├── Presentation/         # Presentation layer
│   ├── ViewModel/       # API response models
│   └── ViewQuery/       # View query interfaces
└── Resource/            # Routes and resources
```

## Database Schema

The `notifications` table has the following structure:

- `id` (primary key)
- `user_id` (foreign key to users table)
- `message` (text)
- `is_read` (boolean, default false)
- `read_at` (timestamp, nullable)
- `created_at` and `updated_at` timestamps

## API Endpoints

### List Notifications
```
GET /api/v1/notifications
```

**Query Parameters:**
- `is_read` (boolean, optional) - Filter by read status
- `search` (string, optional) - Search in message content
- `per_page` (integer, optional) - Number of items per page (default: 15)
- `page` (integer, optional) - Page number (default: 1)

**Response:**
```json
{
    "status": "success",
    "message": "Notifications retrieved successfully",
    "data": {
        "items": [
            {
                "id": 1,
                "message": "Your ad has been approved",
                "is_read": false,
                "read_at": null,
                "created_at": "2024-01-01T00:00:00.000000Z",
                "updated_at": "2024-01-01T00:00:00.000000Z"
            }
        ],
        "meta": {
            "current_page": 1,
            "per_page": 15,
            "total": 1,
            "last_page": 1
        }
    }
}
```

### Mark Notification as Read
```
POST /api/v1/notifications/{id}/mark-as-read
```

**Response:**
```json
{
    "status": "success",
    "message": "Notification marked as read successfully",
    "data": {}
}
```

### Mark All Notifications as Read
```
POST /api/v1/notifications/mark-all-as-read
```

**Response:**
```json
{
    "status": "success",
    "message": "Successfully marked 3 notifications as read",
    "data": {
        "marked_count": 3
    }
}
```

## Usage Examples

### Creating a Notification
```php
use App\Component\Notification\Application\Service\NotificationService;

class SomeService
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function someAction()
    {
        // Create a notification for a user
        $this->notificationService->create($userId, 'Your action was successful!');
    }
}
```

### Getting Unread Count
```php
use App\Component\Notification\Application\Service\NotificationService;

$unreadCount = $this->notificationService->getUnreadCount($user);
```

## Features

- ✅ List notifications with pagination
- ✅ Filter by read/unread status
- ✅ Search in notification messages
- ✅ Mark individual notification as read
- ✅ Mark all notifications as read
- ✅ Get unread count
- ✅ User isolation (users can only access their own notifications)
- ✅ OpenAPI documentation
- ✅ Comprehensive test coverage
- ✅ Factory for testing

## Security

- All endpoints require authentication via Sanctum
- Users can only access their own notifications
- Proper validation and error handling

## Testing

Run the notification tests:
```bash
php artisan test tests/Feature/NotificationTest.php
```

## Migration

To create the notifications table:
```bash
php artisan migrate
```
