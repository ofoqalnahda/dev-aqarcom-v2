<?php

namespace App\Component\Ad\Infrastructure\Service;

use AllowDynamicProperties;
use App\Component\Ad\Application\Service\ReasonServiceInterface;
use App\Component\Ad\Application\Repository\ReasonRepository;
use App\Component\Ad\Domain\Enum\MainType;
use Illuminate\Contracts\Auth\Authenticatable;


class ReasonService implements ReasonServiceInterface
{
    protected ReasonRepository $reasonRepository;

    public function __construct(ReasonRepository $reasonRepository)
    {
        $this->reasonRepository = $reasonRepository;
    }

    public function update($id, array $data): mixed
    {
        return $this->reasonRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->reasonRepository->delete($id);
    }

    public function create( $data): mixed
    {
        return $this->reasonRepository->create( $data);
    }

    public function find(int|string $id): mixed
    {
        return $this->reasonRepository->find($id);
    }


    public function index(): mixed
    {
        return $this->reasonRepository->index();

    }
}
