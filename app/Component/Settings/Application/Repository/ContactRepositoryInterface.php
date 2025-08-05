<?php

namespace App\Component\Settings\Application\Repository;

use App\Component\Settings\Data\Entity\Contact;
use Illuminate\Database\Eloquent\Collection;

interface ContactRepositoryInterface
{
    public function create(array $data): Contact;
    
    public function findById(int $id): ?Contact;
    
    public function findByUserId(int $userId): Collection;
    
    public function findAll(): Collection;
    
    public function update(Contact $contact, array $data): Contact;
    
    public function delete(Contact $contact): bool;
} 