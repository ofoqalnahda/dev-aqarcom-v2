<?php

declare(strict_types = 1);

namespace App\Component\Money\Test\Unit\Formatter;

use App\Component\Money\Infrastructure\Formatter\MoneyApplicationFormatter;
use Mockery as M;
use Money\Money;
use Money\MoneyFormatter;
use PHPUnit\Framework\TestCase;

class MoneyFormatterTest extends TestCase
{
    public function testAsMoney(): void
    {
        $money = Money::SAR(1000);

        /** @var MoneyFormatter|M\MockInterface $moneyFormatter */
        $moneyFormatter = M::mock(MoneyFormatter::class)
            ->shouldReceive('format')
            ->with($money)
            ->once()
            ->andReturn('SAR 10.00')
            ->getMock();

        /** @var MoneyFormatter|M\MockInterface $decimalFormatter */
        $decimalFormatter = M::mock(MoneyFormatter::class)
            ->shouldNotReceive('format')
            ->getMock();

        $formatter = new MoneyApplicationFormatter(moneyFormatter: $moneyFormatter, decimalFormatter: $decimalFormatter);

        $this->assertSame('SAR 10.00', $formatter->asMoney($money));
    }

    public function testAsDecimal(): void
    {
        $money = Money::SAR(1000);

        /** @var MoneyFormatter|M\MockInterface $moneyFormatter */
        $moneyFormatter = M::mock(MoneyFormatter::class)
            ->shouldNotReceive('format')
            ->getMock();

        /** @var MoneyFormatter|M\MockInterface $decimalFormatter */
        $decimalFormatter = M::mock(MoneyFormatter::class)
            ->shouldReceive('format')
            ->with($money)
            ->once()
            ->andReturn('10.00')
            ->getMock();

        $formatter = new MoneyApplicationFormatter(moneyFormatter: $moneyFormatter, decimalFormatter: $decimalFormatter);

        $this->assertSame(10.00, $formatter->asDecimal($money));
    }
}
