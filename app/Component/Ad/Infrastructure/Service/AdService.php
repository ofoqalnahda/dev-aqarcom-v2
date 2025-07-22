<?php

namespace App\Component\Ad\Infrastructure\Service;

use AllowDynamicProperties;
use App\Component\Ad\Application\Service\AdServiceInterface;
use App\Component\Ad\Application\Repository\AdRepository;
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

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function CheckIsExitAd(int|string $license_number): mixed
    {
        return $this->adRepository->CheckIsExitAd($license_number);
    }

    public function CheckAdLicense(CheckAdLicenseRequest $request, ?Authenticatable $user)
    {
        return $this->adRepository->CheckAdLicense($request,$user);
    }
}
