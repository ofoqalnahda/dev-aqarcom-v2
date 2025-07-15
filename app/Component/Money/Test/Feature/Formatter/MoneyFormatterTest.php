<?php

declare(strict_types = 1);

namespace App\Component\Money\Test\Feature\Formatter;

use App\Component\Money\Application\Formatter\MoneyFormatter;
use Money\Money;
use Tests\TestCase;

class MoneyFormatterTest extends TestCase
{
    private MoneyFormatter $formatter;

    public function testAsMoney(): void
    {
        $this->assertSame(
            html_entity_decode('SAR&nbsp;10.00'),
            $this->formatter->asMoney(Money::SAR(1000)),
        );
    }

    public function testAsDecimal(): void
    {
        $this->assertSame(
            10.00,
            $this->formatter->asDecimal(Money::SAR(1000)),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->formatter = $this->app->make(MoneyFormatter::class);
    }
}
