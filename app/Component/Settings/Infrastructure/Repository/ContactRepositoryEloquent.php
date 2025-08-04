<?php

namespace App\Component\Settings\Infrastructure\Repository;

use App\Component\Settings\Application\Repository\ContactRepositoryInterface;
use App\Component\Settings\Data\Entity\Contact;
use Illuminate\Database\Eloquent\Collection;

class ContactRepositoryEloquent implements ContactRepositoryInterface
{
    public function create(array $data): Contact
    {
        return Contact::create($data);
    }
    
    public function findById(int $id): ?Contact
    {
        return Contact::with('user')->find($id);
    }
    
    public function findByUserId(int $userId): Collection
    {
        return Contact::where('user_id', $userId)
                     ->orderBy('created_at', 'desc')
                     ->get();
    }
    
    public function findAll(): Collection
    {
        return Contact::with('user')
                     ->orderBy('created_at', 'desc')
                     ->get();
    }
    
    public function update(Contact $contact, array $data): Contact
    {
        $contact->update($data);
        return $contact->fresh();
    }
    
    public function delete(Contact $contact): bool
    {
        return $contact->delete();
    }
} 