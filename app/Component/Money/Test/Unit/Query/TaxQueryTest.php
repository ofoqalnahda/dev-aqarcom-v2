<?php

declare(strict_types = 1);

namespace App\Component\Money\Test\Unit\Query;

use App\Component\Money\Domain\Enum\CurrencyEnum;
use App\Component\Money\Domain\Exception\CurrencyException;
use App\Component\Money\Infrastructure\Query\TaxApplicationQuery;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Translation\Translator;
use Mockery as M;
use PHPUnit\Framework\TestCase;

class TaxQueryTest extends TestCase
{
    /** @throws CurrencyException */
    public function testGetRateByCurrencyWhenCorrectRateIsSet(): void
    {
        $currency = CurrencyEnum::SAR;

        /** @var Repository|M\MockInterface $config */
        $config = M::mock(Repository::class)
            ->shouldReceive('get')
            ->with("money.tax.$currency->value")
            ->once()
            ->andReturn(26)
            ->getMock();

        /** @var Translator|M\MockInterface $translator */
        $translator = M::mock(Translator::class)
            ->shouldNotReceive('get')
            ->getMock();

        $query = new TaxApplicationQuery(config: $config, translator: $translator);

        $this->assertSame(26, $query->getRateByCurrency($currency));
    }

    public function testGetRateByCurrencyWhenIncorrectRateIsSet(): void
    {
        $currency = CurrencyEnum::SAR;

        /** @var Repository|M\MockInterface $config */
        $config = M::mock(Repository::class)
            ->shouldReceive('get')
            ->with("money.tax.$currency->value")
            ->once()
            ->andReturn(0)
            ->getMock();

        /** @var Translator|M\MockInterface $translator */
        $translator = M::mock(Translator::class)
            ->shouldReceive('get')
            ->andReturn('Currency has invalid rate set.')
            ->getMock();

        $query = new TaxApplicationQuery(config: $config, translator: $translator);

        $this->expectException(CurrencyException::class);
        $query->getRateByCurrency($currency);
    }
}
