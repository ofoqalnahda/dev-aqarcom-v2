<?php

namespace App\Component\Ad\Infrastructure\Service;

use AllowDynamicProperties;
use App\Component\Ad\Application\Service\AdServiceInterface;
use App\Component\Ad\Application\Repository\AdRepository;
use Illuminate\Support\Facades\Hash;
use App\Component\Ad\Presentation\ViewQuery\AdViewQueryInterface;
use Illuminate\Support\Str;


class AdService implements AdServiceInterface
{
    protected AdRepository $adRepository;
    protected AdViewQueryInterface $adViewQuery;

    public function __construct(AdRepository $adRepository, AdViewQueryInterface $adViewQuery)
    {
        $this->adRepository = $adRepository;
        $this->adViewQuery = $adViewQuery;
    }

    public function update($id, array $data)
    {
        return $this->adRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->adRepository->delete($id);
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }
}
