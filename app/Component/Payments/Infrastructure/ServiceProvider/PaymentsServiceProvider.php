<?php

namespace App\Component\Payments\Infrastructure\ServiceProvider;

use App\Component\Common\Infrastructure\ServiceProvider\ServiceProvider;

class PaymentsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        parent::register();
    }

    public function boot(): void
    {

    }

    protected function regularBindings(): array
    {
        return [
            // Repository bindings
            \App\Component\Payments\Application\Repository\PromoCodeRepositoryInterface::class => \App\Component\Payments\Infrastructure\Repository\PromoCodeRepositoryEloquent::class,
            \App\Component\Payments\Application\Repository\SubscriptionRepositoryInterface::class => \App\Component\Payments\Infrastructure\Repository\SubscriptionRepositoryEloquent::class,
            
            // Service bindings
            \App\Component\Payments\Application\Service\PaymentServiceInterface::class => \App\Component\Payments\Infrastructure\Service\PaymentService::class,
            
            // Mapper bindings
            \App\Component\Payments\Application\Mapper\PaymentMapperInterface::class => \App\Component\Payments\Infrastructure\Mapper\PaymentMapper::class,
            
            // ViewQuery bindings
            \App\Component\Payments\Presentation\ViewQuery\PaymentViewQueryInterface::class => \App\Component\Payments\Infrastructure\ViewQuery\PaymentViewQuery::class,
        ];
    }
} 