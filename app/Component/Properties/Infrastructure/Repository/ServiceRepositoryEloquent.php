<?php

namespace App\Component\Properties\Infrastructure\Repository;

use App\Component\Properties\Application\Repository\ServiceRepository;
use App\Component\Properties\Data\Entity\Service\Service;

class ServiceRepositoryEloquent implements ServiceRepository
{
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $service = $this->model->find($id);
        if ($service) {
            $service->update($data);
            return $service->fresh();
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $service = $this->model->find($id);
        if ($service) {
            return $service->delete();
        }
        return false;
    }
}
