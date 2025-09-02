<?php

namespace App\Component\Properties\Application\Service;

interface ServiceServiceInterface
{
    public function createService(array $data);
    public function updateService(int $id, array $data);
    public function deleteService(int $id): bool;
    public function getService(int $id);
    public function getServicesByType(string $type);
    public function getActiveServices();
    public function searchServicesByName(string $name);
    public function toggleServiceStatus(int $id): bool;
}



