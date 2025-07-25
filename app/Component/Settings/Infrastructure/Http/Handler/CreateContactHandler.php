<?php

namespace App\Component\Settings\Infrastructure\Http\Handler;

use App\Component\Settings\Infrastructure\Http\Request\CreateContactRequest;
use App\Component\Settings\Application\Service\ContactServiceInterface;
use App\Component\Settings\Application\Mapper\ContactMapperInterface;
use App\Libraries\Base\Http\Handler;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/settings/contact',
    requestBody: new OA\RequestBody(ref: '#/components/requestBodies/CreateContactRequest'),
    tags: ['Settings'],
    responses: [
        new OA\Response(response: 201, description: 'Contact message created successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', ref: '#/components/schemas/ContactViewModel'),
            ],
            type: 'object'
        )),
    ]
)]
class CreateContactHandler extends Handler
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

    public function __invoke(CreateContactRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        
        // Add user_id if authenticated, otherwise it will be null for anonymous contacts
        if ($request->user()) {
            $data['user_id'] = $request->user()->id;
        }

        $contact = $this->contactService->createContactMessage($data);
        $contactViewModel = $this->contactMapper->toViewModel($contact);

        return response()->json([
            'status' => 'success',
            'message' => 'Contact message sent successfully',
            'data' => $contactViewModel->toArray(),
        ], 201);
    }
} 