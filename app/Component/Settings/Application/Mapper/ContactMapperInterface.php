<?php

namespace App\Component\Settings\Application\Mapper;

use App\Component\Settings\Data\Entity\Contact;
use App\Component\Settings\Presentation\ViewModel\ContactViewModel;
use Illuminate\Database\Eloquent\Collection;

interface ContactMapperInterface
{
    public function toViewModel(Contact $contact): ContactViewModel;
    
    public function toViewModelCollection(Collection $contacts): array;
} 