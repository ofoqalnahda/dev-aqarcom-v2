<?php

namespace App\Component\Properties\Presentation\ViewQuery;

interface ServiceViewQueryInterface
{
    public function find(int $id);
    public function findByType(string $type);
    public function findActiveServices();
    public function findByName(string $name);
    public function getAllServices();
}



