<?php

namespace App\Component\Ad\Infrastructure\Service;

use AllowDynamicProperties;
use App\Component\Ad\Application\Service\AdServiceInterface;
use App\Component\Ad\Application\Repository\AdRepository;
use App\Component\Ad\Domain\Enum\MainType;
use App\Component\Ad\Infrastructure\Http\Request\CheckAdLicenseRequest;
use Illuminate\Contracts\Auth\Authenticatable;
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

    public function create(MainType $main_type , $request, $user): mixed
    {
        return $this->adRepository->create( $main_type, $request, $user);
    }

    public function find(int|string $id): mixed
    {
        return $this->adRepository->find($id);
    }

    public function CheckIsExitAd(int|string $license_number): mixed
    {
        return $this->adRepository->CheckIsExitAd($license_number);
    }

    public function CheckAdLicense(CheckAdLicenseRequest $request, ?Authenticatable $user)
    {
        return $this->adRepository->CheckAdLicense($request,$user);
    }

    public function filter(MainType $mainType, array $filters,$withDist=false)
    {
        return $this->adRepository->filter($mainType,$filters,$withDist);
    }

    public function getDataForFilter(): array
    {
        return $this->adRepository->getDataForFilter();
    }

    public function getStores()
    {
        return $this->adRepository->getStores();
    }

    public function findBySlug($slug)
    {
        return $this->adRepository->findBySlug($slug);
    }
}
