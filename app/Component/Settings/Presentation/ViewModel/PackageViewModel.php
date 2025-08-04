<?php

namespace App\Component\Settings\Presentation\ViewModel;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "PackageViewModel",
    description: "Package View Model",
    required: ["id", "name", "type", "period_months", "description", "price", "is_active"],
    properties: [
        new OA\Property(property: "id", type: "integer"),
        new OA\Property(property: "name", type: "string"),
        new OA\Property(property: "type", type: "string", enum: ["individual", "companies"]),
        new OA\Property(property: "period_months", type: "integer"),
        new OA\Property(property: "description", type: "string"),
        new OA\Property(property: "price", type: "number", format: "decimal"),
        new OA\Property(property: "price_before_discount", type: "number", format: "decimal", nullable: true),
        new OA\Property(property: "discount_percentage", type: "number", format: "float", nullable: true),
        new OA\Property(property: "features", type: "array", items: new OA\Items(type: "string")),
        new OA\Property(property: "is_active", type: "boolean"),
        new OA\Property(property: "sort_order", type: "integer"),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ],
    type: "object",
)]
class PackageViewModel
{
    public $id;
    public $name;
    public $type;
    public $period_months;
    public $description;
    public $price;
    public $price_before_discount;
    public $discount_percentage;
    public $features;
    public $is_active;
    public $sort_order;
    public $created_at;
    public $updated_at;

    public function __construct($package)
    {
        $this->id = $package->id;
        $this->name = $package->name;
        $this->type = $package->type;
        $this->period_months = $package->period_months;
        $this->description = $package->description;
        $this->price = $package->price;
        $this->price_before_discount = $package->price_before_discount;
        $this->discount_percentage = $package->discount_percentage;
        $this->features = $package->features ?? [];
        $this->is_active = $package->is_active;
        $this->sort_order = $package->sort_order;
        $this->created_at = $package->created_at;
        $this->updated_at = $package->updated_at;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
