<?php

namespace App\Component\Auth\Infrastructure\Http\Handler;

use App\Component\Auth\Application\Mapper\UserMapperInterface;
use App\Component\Auth\Infrastructure\Http\Request\VerifyCodeRequest;
use App\Component\Auth\Application\Service\UserServiceInterface;
use App\Component\Auth\Presentation\ViewQuery\UserViewQueryInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/auth/verify-code',
    requestBody: new OA\RequestBody(ref: '#/components/requestBodies/VerifyCodeRequest'),
    tags: ['Auth'],
    responses: [
        new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', properties: [
                    new OA\Property(property: 'token', type: 'string'),
                    new OA\Property(property: 'user', ref: '#/components/schemas/UserViewModel'),
                ], type: 'object'),
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
    protected UserMapperInterface $userMapper;

    public function __construct(UserServiceInterface $userService, UserMapperInterface $userMapper)
    {
        $this->userService = $userService;
        $this->userMapper = $userMapper;

    }

    public function __invoke(VerifyCodeRequest $request): \Illuminate\Http\JsonResponse
    {

        $code = $request->input('code');
        $user_id = $request->input('user_id');
        $user= $this->userService->verifyCode($user_id, $code);
        if ($user) {
            $token = $user->createToken('auth_token')->plainTextToken;
            $userViewModel = $this->userMapper->toViewModel($user);
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => [
                    'token' => $token,
                    'user' => $userViewModel->toArray(),
                ],
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid code',
        ], 400);
    }
}
