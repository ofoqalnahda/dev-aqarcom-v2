<?php

namespace App\Component\Auth\Infrastructure\Http\Handler;

use App\Component\Auth\Infrastructure\Http\Request\VerifyCodeRequest;
use App\Component\Auth\Application\Service\UserServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/auth/verify-code',
    requestBody: new OA\RequestBody(ref: '#/components/requestBodies/VerifyCodeRequest'),
    security: [['sanctum' => []]],
    tags: ['Auth'],
    responses: [
        new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
            ],
            type: 'object'
        )),
        new OA\Response(response: 400, description: 'Invalid code', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
            ],
            type: 'object'
        )),
    ]
)]
class VerifyCodeHandler extends Handler
{
    protected UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(VerifyCodeRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $code = $request->input('code');
        if ($this->userService->verifyCode($user, $code)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Code verified',
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid code',
        ], 400);
    }
} 