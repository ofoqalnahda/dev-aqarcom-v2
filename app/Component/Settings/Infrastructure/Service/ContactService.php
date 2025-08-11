<?php

namespace App\Component\Settings\Infrastructure\Service;

use App\Component\Settings\Application\Service\ContactServiceInterface;
use App\Component\Settings\Application\Repository\ContactRepositoryInterface;
use App\Component\Settings\Data\Entity\Contact;
use Illuminate\Database\Eloquent\Collection;

class ContactService implements ContactServiceInterface
{
    protected ContactRepositoryInterface $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function createContactMessage(array $data): Contact
    {
        $contactData = array_merge($data, [
            'status' => 'pending',
        ]);

        return $this->contactRepository->create($contactData);
    }

    public function getUserContactMessages(int $userId): Collection
    {
        return $this->contactRepository->findByUserId($userId);
    }

    public function getAllContactMessages(): Collection
    {
        return $this->contactRepository->findAll();
    }

    public function getContactMessage(int $id): ?Contact
    {
        return $this->contactRepository->findById($id);
    }

    public function updateContactStatus(int $id, string $status, ?string $responseMessage = null): Contact
    {
        $contact = $this->contactRepository->findById($id);

        if (!$contact) {
            throw new \Exception('Contact message not found');
        }

        $updateData = [
            'status' => $status,
        ];

        if ($responseMessage) {
            $updateData['response_message'] = $responseMessage;
            $updateData['responded_at'] = now();
        }

        return $this->contactRepository->update($contact, $updateData);
    }
}
