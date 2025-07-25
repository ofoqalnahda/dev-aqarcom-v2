<?php

namespace App\Component\Settings\Infrastructure\Http\Handler;

use App\Component\Settings\Application\Service\ProfitSubscriberServiceInterface;
use App\Component\Settings\Application\Mapper\ProfitSubscriberMapperInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/settings/profit-subscribers',
    tags: ['Settings'],
    parameters: [
        new OA\Parameter(
            name: 'search',
            description: 'Search by name, email, or phone',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'string')
        ),
    ],
    responses: [
        new OA\Response(response: 200, description: 'Profit subscribers retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/ProfitSubscriberViewModel')),
            ],
            type: 'object'
        )),
    ]
)]
class GetProfitSubscribersHandler extends Handler
{
    protected ProfitSubscriberServiceInterface $subscriberService;
    protected ProfitSubscriberMapperInterface $subscriberMapper;

    public function __construct(
        ProfitSubscriberServiceInterface $subscriberService,
        ProfitSubscriberMapperInterface $subscriberMapper
    ) {
        $this->subscriberService = $subscriberService;
        $this->subscriberMapper = $subscriberMapper;
    }

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $search = $request->query('search');
        $subscribers = $this->subscriberService->getAllSubscribers($search);
        $subscriberViewModels = $this->subscriberMapper->toViewModelCollection($subscribers);

        return response()->json([
            'status' => 'success',
            'message' => 'Profit subscribers retrieved successfully',
            'data' => array_map(fn($subscriber) => $subscriber->toArray(), $subscriberViewModels),
        ]);
    }
} 