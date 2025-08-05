<?php

namespace App\Component\Settings\Infrastructure\Mapper;

use App\Component\Settings\Application\Mapper\ContactMapperInterface;
use App\Component\Settings\Data\Entity\Contact;
use App\Component\Settings\Presentation\ViewModel\ContactViewModel;
use Illuminate\Database\Eloquent\Collection;

class ContactMapper implements ContactMapperInterface
{
    public function toViewModel(Contact $contact): ContactViewModel
    {
        return new ContactViewModel($contact);
    }
    
    public function toViewModelCollection(Collection $contacts): array
    {
        return array_map(function ($contact) {
            return $this->toViewModel($contact);
        }, $contacts->all());
    }
} 