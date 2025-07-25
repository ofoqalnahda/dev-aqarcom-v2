<?php

namespace App\Component\Settings\Infrastructure\Http\Handler;

use App\Component\Settings\Application\Service\ContactServiceInterface;
use App\Component\Settings\Application\Mapper\ContactMapperInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/settings/contact/my-messages',
    tags: ['Settings'],
    responses: [
        new OA\Response(response: 200, description: 'User contact messages retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/ContactViewModel')),
            ],
            type: 'object'
        )),
    ]
)]
class GetUserContactsHandler extends Handler
{
    protected ContactServiceInterface $contactService;
    protected ContactMapperInterface $contactMapper;

    public function __construct(
        ContactServiceInterface $contactService,
        ContactMapperInterface $contactMapper
    ) {
        $this->contactService = $contactService;
        $this->contactMapper = $contactMapper;
    }

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $userId = $request->user()->id;
        $contacts = $this->contactService->getUserContactMessages($userId);
        $contactViewModels = $this->contactMapper->toViewModelCollection($contacts);

        return response()->json([
            'status' => 'success',
            'message' => 'User contact messages retrieved successfully',
            'data' => array_map(fn($contact) => $contact->toArray(), $contactViewModels),
        ]);
    }
} 