<?php

declare(strict_types = 1);

namespace App\Component\Money\Test\Feature\Query;

use App\Component\Money\Application\Query\TaxQuery;
use App\Component\Money\Domain\Enum\CurrencyEnum;
use App\Component\Money\Domain\Exception\CurrencyException;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class TaxQueryTest extends TestCase
{
    private TaxQuery $query;

    public function testGetRateByCurrencyWhenRateIsSet(): void
    {
        $currency = CurrencyEnum::SAR;
        Config::set("money.tax.$currency->value", 22);

        $this->assertSame(22, $this->query->getRateByCurrency($currency));
    }

    public function testGetRateByCurrencyWhenRateIsMissing(): void
    {
        $currency = CurrencyEnum::SAR;
        Config::set("money.tax.$currency->value", 0);

        $this->expectException(CurrencyException::class);
        $this->query->getRateByCurrency($currency);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->query = $this->app->make(TaxQuery::class);
    }
}
