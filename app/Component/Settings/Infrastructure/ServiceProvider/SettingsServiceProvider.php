<?php

namespace App\Component\Settings\Infrastructure\ServiceProvider;

use App\Component\Common\Infrastructure\ServiceProvider\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
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
            \App\Component\Settings\Presentation\ViewQuery\SettingViewQueryInterface::class => \App\Component\Settings\Infrastructure\ViewQuery\SettingViewQuery::class,
            \App\Component\Settings\Application\Repository\SettingRepositoryInterface::class => \App\Component\Settings\Infrastructure\Repository\SettingRepositoryEloquent::class,
            \App\Component\Settings\Application\Service\SettingServiceInterface::class => \App\Component\Settings\Infrastructure\Service\SettingService::class,
            \App\Component\Settings\Application\Mapper\SettingMapperInterface::class => \App\Component\Settings\Infrastructure\Mapper\SettingMapper::class,
            
            // Withdrawal bindings
            \App\Component\Settings\Application\Repository\WithdrawalRepositoryInterface::class => \App\Component\Settings\Infrastructure\Repository\WithdrawalRepositoryEloquent::class,
            \App\Component\Settings\Application\Service\WithdrawalServiceInterface::class => \App\Component\Settings\Infrastructure\Service\WithdrawalService::class,
            \App\Component\Settings\Application\Mapper\WithdrawalMapperInterface::class => \App\Component\Settings\Infrastructure\Mapper\WithdrawalMapper::class,
            
            // Profit Subscriber bindings
            \App\Component\Settings\Application\Repository\ProfitSubscriberRepositoryInterface::class => \App\Component\Settings\Infrastructure\Repository\ProfitSubscriberRepositoryEloquent::class,
            \App\Component\Settings\Application\Service\ProfitSubscriberServiceInterface::class => \App\Component\Settings\Infrastructure\Service\ProfitSubscriberService::class,
            \App\Component\Settings\Application\Mapper\ProfitSubscriberMapperInterface::class => \App\Component\Settings\Infrastructure\Mapper\ProfitSubscriberMapper::class,
            
            // Package bindings
            \App\Component\Settings\Application\Repository\PackageRepositoryInterface::class => \App\Component\Settings\Infrastructure\Repository\PackageRepositoryEloquent::class,
            \App\Component\Settings\Application\Service\PackageServiceInterface::class => \App\Component\Settings\Infrastructure\Service\PackageService::class,
            \App\Component\Settings\Application\Mapper\PackageMapperInterface::class => \App\Component\Settings\Infrastructure\Mapper\PackageMapper::class,
            
            // Contact bindings
            \App\Component\Settings\Application\Repository\ContactRepositoryInterface::class => \App\Component\Settings\Infrastructure\Repository\ContactRepositoryEloquent::class,
            \App\Component\Settings\Application\Service\ContactServiceInterface::class => \App\Component\Settings\Infrastructure\Service\ContactService::class,
            \App\Component\Settings\Application\Mapper\ContactMapperInterface::class => \App\Component\Settings\Infrastructure\Mapper\ContactMapper::class,
        ];
    }

} 