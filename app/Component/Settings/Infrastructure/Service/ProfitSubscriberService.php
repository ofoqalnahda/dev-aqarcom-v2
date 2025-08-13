<?php

namespace App\Component\Settings\Infrastructure\Service;

use App\Component\Settings\Application\Service\ProfitSubscriberServiceInterface;
use App\Component\Settings\Application\Repository\ProfitSubscriberRepositoryInterface;
use App\Component\Settings\Data\Entity\ProfitSubscriber;
use Illuminate\Database\Eloquent\Collection;

class ProfitSubscriberService implements ProfitSubscriberServiceInterface
{
    protected ProfitSubscriberRepositoryInterface $subscriberRepository;

    public function __construct(ProfitSubscriberRepositoryInterface $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    public function getAllSubscribers(?string $search = null): Collection
    {
        return $this->subscriberRepository->findAll($search);
    }
    
    public function getSubscriber(int $id): ?ProfitSubscriber
    {
        return $this->subscriberRepository->findById($id);
    }
    
    public function createSubscriber(array $data): ProfitSubscriber
    {
        return $this->subscriberRepository->create($data);
    }
    
    public function updateSubscriber(int $id, array $data): ProfitSubscriber
    {
        $subscriber = $this->subscriberRepository->findById($id);
        
        if (!$subscriber) {
            throw new \Exception('Subscriber not found');
        }

        return $this->subscriberRepository->update($subscriber, $data);
    }
    
    public function deleteSubscriber(int $id): bool
    {
        $subscriber = $this->subscriberRepository->findById($id);
        
        if (!$subscriber) {
            throw new \Exception('Subscriber not found');
        }

        return $this->subscriberRepository->delete($subscriber);
    }
} 