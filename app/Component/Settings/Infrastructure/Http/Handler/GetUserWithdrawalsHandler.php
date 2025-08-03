<?php

namespace App\Component\Settings\Infrastructure\Http\Handler;

use App\Component\Settings\Application\Service\WithdrawalServiceInterface;
use App\Component\Settings\Application\Mapper\WithdrawalMapperInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/settings/withdrawals',
    tags: ['Settings'],
    responses: [
        new OA\Response(response: 200, description: 'User withdrawal requests retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/WithdrawalViewModel')),
            ],
            type: 'object'
        )),
    ]
)]
class GetUserWithdrawalsHandler extends Handler
{
    protected WithdrawalServiceInterface $withdrawalService;
    protected WithdrawalMapperInterface $withdrawalMapper;

    public function __construct(
        WithdrawalServiceInterface $withdrawalService,
        WithdrawalMapperInterface $withdrawalMapper
    ) {
        $this->withdrawalService = $withdrawalService;
        $this->withdrawalMapper = $withdrawalMapper;
    }

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $userId = $request->user()->id;
        $withdrawalRequests = $this->withdrawalService->getUserWithdrawalRequests($userId);
        $withdrawalViewModels = $this->withdrawalMapper->toViewModelCollection($withdrawalRequests);

        return response()->json([
            'status' => 'success',
            'message' => 'User withdrawal requests retrieved successfully',
            'data' => array_map(fn($withdrawal) => $withdrawal->toArray(), $withdrawalViewModels),
        ]);
    }
} 