# Payments Component

This component handles all payment-related functionality for the Aqarkom application, including package subscriptions and promo code management.

## Features

- **Package Subscriptions**: Users can subscribe to packages with different payment methods
- **Promo Code System**: Support for percentage and fixed amount discounts
- **Payment Processing**: Handle different payment statuses and methods
- **Subscription Management**: Track subscription status and validity periods

## Architecture

Following Domain-Driven Design (DDD) principles:

### Domain Layer
- **Entities**: `Subscription`, `PromoCode`
- **Enums**: `PaymentStatus`, `SubscriptionStatus`, `PaymentMethod`
- **DTOs**: `PromoCodeCalculationDto`, `SubscriptionDto`
- **Exceptions**: `InvalidPromoCodeException`

### Application Layer
- **Services**: `PaymentServiceInterface`
- **Repositories**: `PromoCodeRepositoryInterface`, `SubscriptionRepositoryInterface`
- **Mappers**: `PaymentMapperInterface`

### Infrastructure Layer
- **HTTP Handlers**: API endpoints for payment operations
- **Repositories**: Eloquent implementations
- **Services**: Business logic implementations
- **ServiceProvider**: Dependency injection bindings

### Presentation Layer
- **ViewModels**: Data transfer objects for API responses

## API Endpoints

### Apply Promo Code
```
POST /api/v1/payments/apply-promo-code
```

**Request Body:**
```json
{
    "package_id": 1,
    "code": "WELCOME50"
}
```

**Response:**
```json
{
    "status": "success",
    "message": "Promo code applied successfully",
    "data": {
        "package_id": 1,
        "original_price": 190.00,
        "final_price": 95.00,
        "discount_amount": 95.00,
        "discount_percentage": 50.00,
        "promo_code": "WELCOME50",
        "is_valid": true,
        "error_message": null
    }
}
```

### Subscribe to Package
```
POST /api/v1/payments/subscribe
```

**Request Body:**
```json
{
    "package_id": 1,
    "promo_code": "WELCOME50",
    "payment_method": "electronic",
    "payment_details": {
        "card_number": "**** **** **** 1234"
    }
}
```

**Response:**
```json
{
    "status": "success",
    "message": "Subscription created successfully",
    "data": {
        "subscription": {
            "id": 1,
            "user_id": 1,
            "package_id": 1,
            "promo_code_id": 1,
            "original_price": 190.00,
            "final_price": 95.00,
            "discount_amount": 95.00,
            "discount_percentage": 50.00,
            "payment_method": "electronic",
            "payment_status": "pending",
            "subscription_status": "active",
            "start_date": "2024-01-01T00:00:00Z",
            "end_date": "2024-04-01T00:00:00Z",
            "transaction_id": null,
            "payment_details": {...},
            "created_at": "2024-01-01T00:00:00Z",
            "updated_at": "2024-01-01T00:00:00Z",
            "package": {...},
            "promo_code": {...}
        }
    }
}
```

### Get User Subscriptions
```
GET /api/v1/payments/subscriptions
```

**Response:**
```json
{
    "status": "success",
    "message": "User subscriptions retrieved successfully",
    "data": {
        "subscriptions": [...]
    }
}
```

## Database Schema

### promo_codes Table
- `id` - Primary key
- `code` - Unique promo code string
- `description` - Description of the promo code
- `discount_type` - 'percentage' or 'fixed_amount'
- `discount_value` - Discount amount or percentage
- `minimum_amount` - Minimum purchase amount required
- `maximum_discount` - Maximum discount limit
- `usage_limit` - Maximum number of times code can be used
- `used_count` - Number of times code has been used
- `valid_from` - Start date of validity
- `valid_until` - End date of validity
- `is_active` - Whether the code is active
- `applicable_packages` - JSON array of applicable package IDs

### subscriptions Table
- `id` - Primary key
- `user_id` - Foreign key to users table
- `package_id` - Foreign key to packages table
- `promo_code_id` - Foreign key to promo_codes table (nullable)
- `original_price` - Original package price
- `final_price` - Final price after discount
- `discount_amount` - Amount of discount applied
- `discount_percentage` - Percentage of discount applied
- `payment_method` - Payment method used
- `payment_status` - Current payment status
- `subscription_status` - Current subscription status
- `start_date` - Subscription start date
- `end_date` - Subscription end date
- `transaction_id` - Payment transaction ID
- `payment_details` - JSON object with payment details

## Usage Examples

### Creating a Promo Code
```php
use App\Component\Payments\Domain\Entity\PromoCode;

$promoCode = PromoCode::create([
    'code' => 'SAVE20',
    'description' => '20% off all packages',
    'discount_type' => 'percentage',
    'discount_value' => 20.00,
    'minimum_amount' => 50.00,
    'usage_limit' => 100,
    'valid_until' => now()->addMonths(3),
    'is_active' => true,
]);
```

### Applying a Promo Code
```php
use App\Component\Payments\Application\Service\PaymentServiceInterface;

$calculation = $paymentService->calculatePromoCode(1, 'SAVE20');
if ($calculation->isValid) {
    echo "Final price: " . $calculation->finalPrice;
} else {
    echo "Error: " . $calculation->errorMessage;
}
```

### Creating a Subscription
```php
use App\Component\Payments\Domain\Dto\SubscriptionDto;
use App\Component\Payments\Domain\Enum\PaymentMethod;
use App\Component\Payments\Domain\Enum\PaymentStatus;
use App\Component\Payments\Domain\Enum\SubscriptionStatus;

$subscriptionDto = new SubscriptionDto(
    userId: 1,
    packageId: 1,
    promoCodeId: 1,
    originalPrice: 190.00,
    finalPrice: 152.00,
    discountAmount: 38.00,
    discountPercentage: 20.00,
    paymentMethod: PaymentMethod::ELECTRONIC,
    paymentStatus: PaymentStatus::PENDING,
    subscriptionStatus: SubscriptionStatus::ACTIVE,
);

$subscription = $paymentService->createSubscription($subscriptionDto);
```

## Testing

Run the migrations and seeders:
```bash
php artisan migrate
php artisan db:seed --class=PromoCodeSeeder
```

Test the API endpoints:
```bash
# Apply promo code
curl -X POST http://localhost:8000/api/v1/payments/apply-promo-code \
  -H "Content-Type: application/json" \
  -d '{"package_id": 1, "code": "WELCOME50"}'

# Subscribe to package (requires authentication)
curl -X POST http://localhost:8000/api/v1/payments/subscribe \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{"package_id": 1, "payment_method": "electronic"}'
``` 