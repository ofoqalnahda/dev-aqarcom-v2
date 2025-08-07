<?php

namespace App\Component\Auth\Infrastructure\Http\Handler;

use App\Component\Auth\Application\Service\UserServiceInterface;
use App\Component\Auth\Infrastructure\Http\Request\ResendCodeRequest;
use App\Component\Auth\Presentation\ViewQuery\UserViewQueryInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/auth/resend-code',
    requestBody: new OA\RequestBody(ref: '#/components/requestBodies/ResendCodeRequest'),
    tags: ['Auth'],
    responses: [
        new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
            ],
            type: 'object'
        )),
        new OA\Response(response: 400, description: 'Bad Request', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
            ],
            type: 'object'
        )),
        new OA\Response(response: 401, description: 'Unauthorized', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
            ],
            type: 'object'
        )),
    ]
)]
class ResendCodeHandler extends Handler
{
    public function __construct(
        private readonly UserServiceInterface $userService,
    ) {}

    public function __invoke(ResendCodeRequest $request): JsonResponse
    {
        $user_id = $request->input('user_id');

        // Generate and send new verification code
        $resend = $this->userService->resendCode($user_id);
        if (!$resend) {
            return response()->json([
                'status' => 'error',
                'message' => 'No authenticated user found',
            ], 401);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Verification code has been resent',
        ]);
    }
}
