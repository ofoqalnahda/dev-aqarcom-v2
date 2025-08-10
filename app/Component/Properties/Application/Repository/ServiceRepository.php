<?php

namespace App\Component\Properties\Application\Repository;

interface ServiceRepository
{
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id): bool;
}
