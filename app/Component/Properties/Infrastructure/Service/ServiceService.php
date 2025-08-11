<?php

namespace App\Component\Properties\Infrastructure\Service;

use App\Component\Properties\Application\Service\ServiceServiceInterface;
use App\Component\Properties\Application\Repository\ServiceRepository;
use App\Component\Properties\Presentation\ViewQuery\ServiceViewQueryInterface;
use App\Component\Properties\Domain\Enum\ServiceTypeEnum;

class ServiceService implements ServiceServiceInterface
{
    protected $serviceRepository;
    protected $serviceViewQuery;

    public function __construct(ServiceRepository $serviceRepository, ServiceViewQueryInterface $serviceViewQuery)
    {
        $this->serviceRepository = $serviceRepository;
        $this->serviceViewQuery = $serviceViewQuery;
    }

    public function createService(array $data)
    {
        return $this->serviceRepository->create($data);
    }

    public function updateService(int $id, array $data)
    {
        return $this->serviceRepository->update($id, $data);
    }

    public function deleteService(int $id): bool
    {
        return $this->serviceRepository->delete($id);
    }

    public function getService(int $id)
    {
        return $this->serviceViewQuery->find($id);
    }

    public function getServicesByType(string $type)
    {
        return $this->serviceViewQuery->findByType($type);
    }

    public function getActiveServices()
    {
        return $this->serviceViewQuery->findActiveServices();
    }

    public function searchServicesByName(string $name)
    {
        return $this->serviceViewQuery->findByName($name);
    }

    public function getAllServices()
    {
        return $this->serviceViewQuery->getAllServices();
    }

    public function toggleServiceStatus(int $id): bool
    {
        $service = $this->serviceViewQuery->find($id);
        if ($service) {
            $newStatus = !$service->is_active;
            $this->serviceRepository->update($id, ['is_active' => $newStatus]);
            return true;
        }
        return false;
    }
}
