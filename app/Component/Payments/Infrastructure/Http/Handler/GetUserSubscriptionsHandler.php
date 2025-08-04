<?php

namespace App\Component\Payments\Infrastructure\Http\Handler;

use App\Component\Payments\Application\Service\PaymentServiceInterface;
use App\Component\Payments\Application\Mapper\PaymentMapperInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/payments/subscriptions',
    tags: ['Payments'],
    security: [['bearerAuth' => []]],
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
    protected PaymentServiceInterface $paymentService;
    protected PaymentMapperInterface $paymentMapper;

    public function __construct(
        PaymentServiceInterface $paymentService,
        PaymentMapperInterface $paymentMapper
    ) {
        $this->paymentService = $paymentService;
        $this->paymentMapper = $paymentMapper;
    }

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $userId = auth()->id();
        $subscriptions = $this->paymentService->getUserSubscriptions($userId);

        return response()->json([
            'status' => 'success',
            'message' => 'User subscriptions retrieved successfully',
            'data' => [
                'subscriptions' => $subscriptions,
            ],
        ]);
    }
} 