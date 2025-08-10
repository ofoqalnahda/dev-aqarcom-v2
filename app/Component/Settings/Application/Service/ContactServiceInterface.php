<?php

namespace App\Component\Settings\Application\Service;

use App\Component\Settings\Data\Entity\Contact;
use Illuminate\Database\Eloquent\Collection;

interface ContactServiceInterface
{
    public function createContactMessage(array $data): Contact;
    
    public function getUserContactMessages(int $userId): Collection;
    
    public function getAllContactMessages(): Collection;
    
    public function getContactMessage(int $id): ?Contact;
    
    public function updateContactStatus(int $id, string $status, ?string $responseMessage = null): Contact;
} 