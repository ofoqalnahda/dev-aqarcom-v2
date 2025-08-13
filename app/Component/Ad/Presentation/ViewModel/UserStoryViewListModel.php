<?php

namespace App\Component\Ad\Presentation\ViewModel;

use App\Component\Ad\Application\Mapper\AdMapperInterface;
use OpenApi\Attributes as OA;
use ReflectionClass;

#[OA\Schema(
    title: "UserStoryViewListModel",
    description: "User Story List View Model",
    required: ["id","slug"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "name", type: "name"),
        new OA\Property(property: 'stories', ref: '#/components/schemas/AdStoryViewListModel'),
    ],
    type: "object",
)]
class UserStoryViewListModel
{

    public int $id;
    public ?string $name = null;
    public ?array $stories = null;

    public function __construct(AdMapperInterface $adMapper, $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->stories  = $adMapper->toViewStoryLiseModelCollection($data->ads->all());
    }


    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
