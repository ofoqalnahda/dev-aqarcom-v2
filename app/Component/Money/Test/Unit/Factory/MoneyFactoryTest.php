<?php

declare(strict_types = 1);

namespace App\Component\Money\Test\Unit\Factory;

use App\Component\Money\Domain\Enum\CurrencyEnum;
use App\Component\Money\Infrastructure\Factory\MoneyApplicationFactory;
use Money\Currencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;
use Tests\TestCase;

class MoneyFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new MoneyApplicationFactory(new DecimalMoneyParser(\Mockery::mock(Currencies::class)));
        $amount = 999;
        $currency = CurrencyEnum::SAR;

        $expectedMoney = new Money($amount, new Currency($currency->value));
        $actualMoney = $factory->byInteger($amount, $currency);

        $this->assertSame($expectedMoney->getAmount(), $actualMoney->getAmount());
        $this->assertSame($expectedMoney->getCurrency()->getCode(), $actualMoney->getCurrency()->getCode());
    }
}
