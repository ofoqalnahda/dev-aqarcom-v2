<?php

namespace App\Component\Settings\Application\Service;

use App\Component\Settings\Data\Entity\Contact;

interface ContactServiceInterface
{
    public function createContactMessage(array $data): Contact;
    
    public function getUserContactMessages(int $userId): array;
    
    public function getAllContactMessages(): array;
    
    public function getContactMessage(int $id): ?Contact;
    
    public function updateContactStatus(int $id, string $status, ?string $responseMessage = null): Contact;
} 