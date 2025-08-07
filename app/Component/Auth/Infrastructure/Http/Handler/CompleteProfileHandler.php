<?php

namespace App\Component\Auth\Infrastructure\Http\Handler;

use App\Component\Auth\Infrastructure\Http\Request\CompleteProfileRequest;
use App\Component\Auth\Application\Service\UserServiceInterface;
use App\Component\Auth\Application\Mapper\UserMapperInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/auth/complete-profile',
    security: [['sanctum' => []]],
    requestBody: new OA\RequestBody(ref: '#/components/requestBodies/CompleteProfileRequest'),
    tags: ['Auth'],
    responses: [
        new OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', ref: '#/components/schemas/UserViewModel'),
            ],
            type: 'object'
        )),
        new OA\Response(response: 400, description: 'Validation error', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
            ],
            type: 'object'
        )),
    ]
)]
class CompleteProfileHandler extends Handler
{
    protected UserServiceInterface $userService;
    protected UserMapperInterface $userMapper;

    public function __construct(UserServiceInterface $userService, UserMapperInterface $userMapper)
    {
        $this->userService = $userService;
        $this->userMapper = $userMapper;
    }

    public function __invoke(CompleteProfileRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $updatedUser = $this->userService->completeProfile($user, $request->validated());
        $userViewModel = $this->userMapper->toViewModel($updatedUser);
        return response()->json([
            'status' => 'success',
            'message' => 'Profile completed',
            'data' => $userViewModel->toArray(),
        ]);
    }
}
