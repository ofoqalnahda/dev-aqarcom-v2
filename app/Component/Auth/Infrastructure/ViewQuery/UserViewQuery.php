<?php

namespace App\Component\Auth\Infrastructure\ViewQuery;

use App\Component\Auth\Presentation\ViewQuery\UserViewQueryInterface;
use App\Component\Common\Application\Calculator\Address\CoordinateDistanceCalculator;
use App\Component\Common\Domain\Dto\Address\CoordinateDto;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserViewQuery implements UserViewQueryInterface
{
    public function __construct(
        private CoordinateDistanceCalculator $distanceCalculator
    ) {
    }

    public function list(array $filters = []): array
    {
        $query = User::query();
        // Apply filters if needed
        foreach ($filters as $key => $value) {
            $query->where($key, $value);
        }
        return $query->get()->toArray();
    }

    public function find($id): ?User
    {
        return User::query()->findOrFail($id);
    }

    public function findUserByPhone(string $phone)
    {
        return User::query()->where('phone','=', $phone)->first();
    }

    public function findUserByCode(string $code)
    {
        return User::query()->where('code','=', $code)->first();
    }

    public function listServiceProviders(array $filters = [], int $perPage = 15, ?float $userLat = null, ?float $userLng = null): LengthAwarePaginator
    {
        $query = User::query()
            ->where('user_type', '!=', 'individual')
            ->withAvg('ratingsReceived', 'rating')
            ->withCount('ratingsReceived');

        // Add distance calculation if coordinates are provided
        if ($userLat && $userLng) {
            $query->selectRaw('
                users.*,
                (
                    6371 * acos(
                        cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) * sin(radians(latitude))
                    )
                ) AS distance
            ', [$userLat, $userLng, $userLat]);
            
            // Order by distance
            $query->orderBy('distance');
        } else {
            // If no coordinates, add distance as 0 and order by name
            $query->selectRaw('users.*, 0 AS distance');
            $query->orderBy('name');
        }

        // Apply search filter
        if (isset($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%");
        }

        return $query->paginate($perPage);
    }

    public function findServiceProvider(int $id, ?float $userLat = null, ?float $userLng = null): ?User
    {
        $user = User::with([
            'workingHours',
            'previousWorkHistory',
            'services',
            'ratingsReceived.user'
        ])->find($id);

        if (!$user || $user->user_type === 'individual') {
            return null;
        }

        // Calculate distance if coordinates are provided
        if ($userLat && $userLng && $user->latitude && $user->longitude) {
            $fromCoordinate = new CoordinateDto($userLat, $userLng);
            $toCoordinate = new CoordinateDto($user->latitude, $user->longitude);
            $distance = $this->distanceCalculator->inKilometers($fromCoordinate, $toCoordinate);
            $user->distance = $distance;
        } else {
            $user->distance = 0;
        }

        return $user;
    }
}
