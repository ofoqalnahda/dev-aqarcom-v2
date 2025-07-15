<?php

declare(strict_types = 1);

namespace App\Component\Money\Test\Unit\Calculator;

use App\Component\Money\Application\Calculator\MoneyCalculator;
use App\Component\Money\Application\Factory\MoneyFactory;
use App\Component\Money\Infrastructure\Calculator\MoneyApplicationCalculator;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase as TestCase;
use Money\Money;

class MoneyCalculatorTest extends TestCase
{
    /** @dataProvider calculateNettDataProvider */
    public function testCalculateNett(Money $expectedNett, Money $gross, int $taxRate): void
    {
        $this->assertTrue(
            $this->calculator()
                ->calculateNett($gross, $taxRate)
                ->equals($expectedNett)
        );
    }

    /** @dataProvider calculateAmountPercentageWithCapDataProvider */
    public function testCalculateAmountPercentageWithCap(
        Money $amount,
        int $percentage,
        ?Money $cap,
        Money $expectedResult
    ): void
    {
        $this->assertTrue(
            $this->calculator()
                ->calculateAmountPercentageWithCap($amount, $percentage, $cap)
                ->equals($expectedResult)
        );
    }

    /** @dataProvider sumDataProvider */
    public function testSum(
        array $items,
        Money $expectedResult
    ): void
    {
        $this->assertTrue(
            $this->calculator(shouldReceiveEmpty: true)
                ->sum(items: collect($items))
                ->equals($expectedResult)
        );

    }

    /** @dataProvider calculateAmountWithCapProvider */
    public function testCalculateAmountWithCap(Money $amount, Money $cap, Money $expectedResult): void
    {
        $this->assertTrue(
            $this
                ->calculator()
                ->calculateAmountWithCap($amount, $cap)
                ->equals($expectedResult)
        );
    }

    private function calculator(bool $shouldReceiveEmpty = false): MoneyCalculator
    {
        return new MoneyApplicationCalculator(
            moneyFactory: $this->moneyFactoryMock($shouldReceiveEmpty)
        );
    }

    protected function moneyFactoryMock(bool $shouldReceiveEmpty = false): MoneyFactory
    {
        $factory = Mockery::mock(MoneyFactory::class . '[empty]');

        if ($shouldReceiveEmpty) {
            $factory->shouldReceive('empty')->andReturn(Money::SAR(0));
        }

        return $factory;
    }

    public static function calculateNettDataProvider(): iterable
    {
        return [
            [Money::SAR(100), Money::SAR(115), 15],
            [Money::SAR(175), Money::SAR(201), 15],
            [Money::SAR(333), Money::SAR(383), 15],
            [Money::SAR(771), Money::SAR(887), 15],
            [Money::SAR(100), Money::SAR(123), 23],
            [Money::SAR(175), Money::SAR(215), 23],
            [Money::SAR(333), Money::SAR(410), 23],
            [Money::SAR(771), Money::SAR(948), 23],
        ];
    }

    public static function calculateAmountPercentageWithCapDataProvider(): iterable
    {
        return [
            [Money::SAR(100), 15, null, Money::SAR(15)],
            [Money::SAR(87), 37, null, Money::SAR(32)],
            [Money::SAR(90), 100, Money::SAR(75), Money::SAR(75)],
            [Money::SAR(100), 15, Money::SAR(10), Money::SAR(10)],
            [Money::SAR(100), 15, Money::SAR(25), Money::SAR(15)],
        ];
    }

    public static function sumDataProvider(): iterable
    {
        return [
            [
                [],
                Money::SAR(0)
            ],
            [
                [Money::SAR(100), Money::SAR(50), Money::SAR(25)],
                Money::SAR(175)
            ],
            [
                [Money::SAR(100), Money::SAR(-50), Money::SAR(-25)],
                Money::SAR(25)
            ],
            [
                [Money::SAR(100), Money::SAR(-50), Money::SAR(75)],
                Money::SAR(125)
            ],
        ];
    }

    public static function calculateAmountWithCapProvider(): iterable
    {
        return [
            [Money::SAR(100), Money::SAR(50), Money::SAR(50)],
            [Money::SAR(100), Money::SAR(150), Money::SAR(100)],
            [Money::SAR(100), Money::SAR(101), Money::SAR(100)],
            [Money::SAR(100), Money::SAR(99), Money::SAR(99)],
        ];
    }
}
