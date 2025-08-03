<?php

namespace App\Component\Auth\Infrastructure\Http\Handler;

use App\Component\Auth\Infrastructure\Http\Request\LoginRequest;
use App\Component\Auth\Application\Service\UserServiceInterface;
use App\Component\Auth\Application\Mapper\UserMapperInterface;
use App\Models\User;
use App\Component\Auth\Presentation\ViewModel\UserViewModel;
use App\Libraries\Base\Http\Handler;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/auth/login',
    requestBody: new OA\RequestBody(ref: '#/components/requestBodies/LoginRequest'),
    tags: ['Auth'],
    responses: [
        new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', properties: [
                    new OA\Property(property: 'user_id', type: 'integer'),
                ], type: 'object'),
            ],
            type: 'object'
        )),
    ]
)]
class LoginHandler extends Handler
{
    protected UserServiceInterface $userService;
    protected UserMapperInterface $userMapper;

    public function __construct(UserServiceInterface $userService, UserMapperInterface $userMapper)
    {
        $this->userService = $userService;
        $this->userMapper = $userMapper;
    }

    public function __invoke(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $phone = $request->input('phone');
        $user = $this->userService->loginByPhone($phone);
        //TODO: send code
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user_id' => $user->id,
            ],
        ]);
    }
}
