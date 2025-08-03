<?php

namespace App\Component\Settings\Presentation\ViewModel;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "ContactViewModel",
    description: "Contact Message View Model",
    required: ["id", "name", "email", "mobile", "subject", "message", "status", "created_at"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "user_id", type: "integer", nullable: true),
        new OA\Property(property: "name", type: "string"),
        new OA\Property(property: "email", type: "string"),
        new OA\Property(property: "mobile", type: "string"),
        new OA\Property(property: "subject", type: "string"),
        new OA\Property(property: "message", type: "string"),
        new OA\Property(property: "status", type: "string", enum: ["pending", "in_progress", "resolved", "closed"]),
        new OA\Property(property: "responded_at", type: "string", format: "date-time", nullable: true),
        new OA\Property(property: "response_message", type: "string", nullable: true),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ],
    type: "object",
)]
class ContactViewModel
{
    public $id;
    public $user_id;
    public $name;
    public $email;
    public $mobile;
    public $subject;
    public $message;
    public $status;
    public $responded_at;
    public $response_message;
    public $created_at;
    public $updated_at;

    public function __construct($contact)
    {
        $this->id = $contact->id;
        $this->user_id = $contact->user_id;
        $this->name = $contact->name;
        $this->email = $contact->email;
        $this->mobile = $contact->mobile;
        $this->subject = $contact->subject;
        $this->message = $contact->message;
        $this->status = $contact->status;
        $this->responded_at = $contact->responded_at;
        $this->response_message = $contact->response_message;
        $this->created_at = $contact->created_at;
        $this->updated_at = $contact->updated_at;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
} 