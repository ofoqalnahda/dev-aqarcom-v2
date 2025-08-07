<?php

namespace App\Component\Payments\Infrastructure\Http\Handler;

use App\Component\Payments\Presentation\ViewQuery\PaymentViewQueryInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/payments/subscriptions',
    security: [['bearerAuth' => []]],
    tags: ['Payments'],
    responses: [
        new OA\Response(response: 200, description: 'User subscriptions retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', properties: [
                    new OA\Property(property: 'subscriptions', type: 'array', items: new OA\Items(ref: '#/components/schemas/SubscriptionViewModel')),
                ], type: 'object'),
            ],
            type: 'object'
        )),
        new OA\Response(response: 401, description: 'Unauthorized'),
    ]
)]
class GetUserSubscriptionsHandler extends Handler
{
    protected PaymentViewQueryInterface $paymentViewQuery;

    public function __construct(PaymentViewQueryInterface $paymentViewQuery)
    {
        $this->paymentViewQuery = $paymentViewQuery;
    }

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $userId = auth()->id();
        $subscriptions = $this->paymentViewQuery->getUserSubscriptions($userId);

        return response()->json([
            'status' => 'success',
            'message' => 'User subscriptions retrieved successfully',
            'data' => [
                'subscriptions' => array_map(fn($subscription) => $subscription->toArray(), $subscriptions),
            ],
        ]);
    }
}
