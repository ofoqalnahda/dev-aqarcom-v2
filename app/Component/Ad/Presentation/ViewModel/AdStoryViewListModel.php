<?php

namespace App\Component\Ad\Presentation\ViewModel;

use OpenApi\Attributes as OA;
use ReflectionClass;

#[OA\Schema(
    title: "AdStoryViewListModel",
    description: "Ad Story List View Model",
    required: ["id","slug"],
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "slug", type: "string", example: "my-ad-slug"),
        new OA\Property(property: "is_favorite", type: "boolean", example: true),
        new OA\Property(property: "video", type: "string", example: "https://example.com/video.mp4"),
        new OA\Property(property: "image", type: "string", example: "https://example.com/image.jpg"),
        new OA\Property(property: "date", type: "string", example: "منذ 3 أيام"),
        new OA\Property(property: "count_favorites", type: "integer", example: 25),
        new OA\Property(property: "is_view", type: "boolean", example: true),
        new OA\Property(property: "count_view", type: "integer", example: 120),
    ],
    type: "object",
)]
class AdStoryViewListModel
{
    public int $id;
    public ?string $slug = null;
    public ?string $video = '';
    public ?string $image = '';
    public ?string $date = null;
    public bool $is_favorite = false;
    public ?int $count_favorites = null;
    public bool $is_view = false;
    public ?int $count_view = null;

    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->slug = $data->slug;
        $this->video = $data->getFirstMediaUrl('video');
        $this->image = $data->getFirstMediaUrl('main_image');
        $this->date = $data->created_at?->diffForHumans();
        $this->is_favorite = auth()->check() && $data->favoritedByUsers->contains(auth()->id());
        $this->count_favorites = $data->favoritedByUsers?->count();
        $this->is_view = auth()->check() && $data->ViewByUsers->contains(auth()->id());
        $this->count_view = $data->ViewByUsers?->count();


    }


    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
