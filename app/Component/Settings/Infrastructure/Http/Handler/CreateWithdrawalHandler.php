<?php

namespace App\Component\Settings\Infrastructure\Http\Handler;

use App\Component\Settings\Infrastructure\Http\Request\CreateWithdrawalRequest;
use App\Component\Settings\Application\Service\WithdrawalServiceInterface;
use App\Component\Settings\Application\Mapper\WithdrawalMapperInterface;
use App\Libraries\Base\Http\Handler;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/settings/withdrawals',
    requestBody: new OA\RequestBody(ref: '#/components/requestBodies/CreateWithdrawalRequest'),
    tags: ['Settings'],
    responses: [
        new OA\Response(response: 201, description: 'Withdrawal request created successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', ref: '#/components/schemas/WithdrawalViewModel'),
            ],
            type: 'object'
        )),
    ]
)]
class CreateWithdrawalHandler extends Handler
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

    public function __invoke(CreateWithdrawalRequest $request): \Illuminate\Http\JsonResponse
    {
        $userId = $request->user()->id;
        $data = $request->validated();

        $withdrawalRequest = $this->withdrawalService->createWithdrawalRequest($userId, $data);
        $withdrawalViewModel = $this->withdrawalMapper->toViewModel($withdrawalRequest);

        return response()->json([
            'status' => 'success',
            'message' => 'Withdrawal request created successfully',
            'data' => $withdrawalViewModel->toArray(),
        ], 201);
    }
} 