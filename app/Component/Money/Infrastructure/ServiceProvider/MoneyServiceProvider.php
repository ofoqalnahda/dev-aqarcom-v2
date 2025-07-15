<?php

declare(strict_types = 1);

namespace App\Component\Money\Infrastructure\ServiceProvider;

use App\Component\Money\Application\Calculator\MoneyCalculator;
use App\Component\Money\Application\Factory\MoneyFactory;
use App\Component\Money\Application\Factory\PriceFactory;
use App\Component\Money\Application\Formatter\MoneyFormatter;
use App\Component\Money\Application\Query\TaxQuery;
use App\Component\Money\Infrastructure\Calculator\MoneyApplicationCalculator;
use App\Component\Money\Infrastructure\Factory\MoneyApplicationFactory;
use App\Component\Money\Infrastructure\Factory\PriceApplicationFactory;
use App\Component\Money\Infrastructure\Formatter\MoneyApplicationFormatter;
use App\Component\Money\Infrastructure\Query\TaxApplicationQuery;
use Illuminate\Support\ServiceProvider;
use Money\Currencies;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use NumberFormatter;

class MoneyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TaxQuery::class, TaxApplicationQuery::class);
        $this->app->singleton(MoneyFactory::class, MoneyApplicationFactory::class);
        $this->app->singleton(PriceFactory::class, PriceApplicationFactory::class);
        $this->app->singleton(MoneyCalculator::class, MoneyApplicationCalculator::class);
        $this->app->singleton(Currencies::class, Currencies\ISOCurrencies::class);
        $this->app->singleton(MoneyFormatter::class, static fn () => new MoneyApplicationFormatter(
            moneyFormatter: new IntlMoneyFormatter(
                formatter: new NumberFormatter('en_US', NumberFormatter::CURRENCY),
                currencies: new Currencies\ISOCurrencies(),
            ),
            decimalFormatter: new DecimalMoneyFormatter(
                currencies: new Currencies\ISOCurrencies(),
            ),
        ));
    }

    public function boot(): void
    {
        $this->loadTranslations();
        $this->loadConfig();
    }

    private function loadTranslations(): void
    {
        $this->loadTranslationsFrom(app_path('Component/Money/Resource/lang'), 'money');
    }

    private function loadConfig(): void
    {
        $this->mergeConfigFrom(app_path('Component/Money/Resource/config/tax.php'), 'money.tax');
    }
}
