<?php

namespace App\Component\Notification\Presentation\ViewModel;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "NotificationViewModel",
    description: "Notification View Model",
    required: ["id", "message", "is_read"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "message", type: "string"),
        new OA\Property(property: "is_read", type: "boolean"),
        new OA\Property(property: "read_at", type: "string", format: "date-time", nullable: true),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ],
    type: "object",
)]
class NotificationViewModel
{
    public int $id;
    public string $message;
    public bool $is_read;
    public ?string $read_at = null;
    public string $created_at;
    public string $updated_at;

    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->message = $data->message;
        $this->is_read = $data->is_read;
        $this->read_at = $data->read_at?->toISOString();
        $this->created_at = $data->created_at->toISOString();
        $this->updated_at = $data->updated_at->toISOString();
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
