<?php

namespace App\Component\Properties\Infrastructure\ViewQuery;

use App\Component\Properties\Presentation\ViewQuery\ServiceViewQueryInterface;
use App\Component\Properties\Data\Entity\Service\Service;

class ServiceViewQuery implements ServiceViewQueryInterface
{
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function findByType(string $type)
    {
        return $this->model->where('type', $type)->get();
    }

    public function findActiveServices()
    {
        return $this->model->where('is_active', true)->get();
    }

    public function findByName(string $name)
    {
        return $this->model->where('name', 'like', "%{$name}%")->get();
    }

    public function getAllServices()
    {
        return $this->model->all();
    }
}



