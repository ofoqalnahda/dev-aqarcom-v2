<?php

namespace App\Component\Auth\Infrastructure\Http\Handler;

use App\Component\Auth\Application\Service\UserServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/auth/logout',
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
        new OA\Response(response: 401, description: 'Unauthorized', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
            ],
            type: 'object'
        )),
    ]
)]
class LogoutHandler extends Handler
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {}

    public function __invoke(): JsonResponse
    {
        $user = Auth::user();
        
        if ($user) {
            // Use service to handle logout
            $this->userService->logout($user);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Logged out successfully',
            ]);
        }
        
        return response()->json([
            'status' => 'error',
            'message' => 'No authenticated user found',
        ], 401);
    }
} 