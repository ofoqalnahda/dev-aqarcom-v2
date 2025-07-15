<?php

namespace App\Libraries\Money;

use Webmozart\Assert\Assert;

final class Tax
{
    private const CALCULATION_PRECISION = 6;
    private const ROUND_PRECISION = 2;
    private const ROUND_CENTS_PRECISION = 0;
    private const MAX_TAX_RATE = 100;

    private int $value;

    public function __construct(int $tax)
    {
        $this->validateTaxValue($tax);
        $this->value = $tax;
    }

    public static function forValue(int $tax): self
    {
        return new self($tax);
    }

    public static function build(
        float $nett,
        float $gross,
    ): self
    {
        if ($nett <= 0) {
            return new self(0);
        }

        // Calculate tax rate
        $grossDividedByNett = bcdiv($gross, $nett, self::CALCULATION_PRECISION);
        $taxPercent = bcmul($grossDividedByNett, 100, self::CALCULATION_PRECISION);
        $taxRate = bcsub($taxPercent, 100, self::CALCULATION_PRECISION);

        // Ensure tax rate doesn't exceed maximum
        $taxRate = min((float)$taxRate, self::MAX_TAX_RATE);
        $taxRate = max(0, round($taxRate));

        return new self((int)$taxRate);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function calculateGross(float $nett): float
    {
        $tax = bcadd($this->getValue(), 100, self::CALCULATION_PRECISION);
        $gross = bcdiv(bcmul($nett, $tax, self::CALCULATION_PRECISION), 100, self::CALCULATION_PRECISION);

        return (float) round($gross, self::ROUND_PRECISION);
    }

    public function calculateGrossInCents(int $nett): int
    {
        $tax = bcadd($this->getValue(), 100, self::CALCULATION_PRECISION);
        $gross = bcdiv(bcmul($nett, $tax, self::CALCULATION_PRECISION), 100, self::CALCULATION_PRECISION);

        return (int) round($gross, self::ROUND_CENTS_PRECISION);
    }

    public function calculateNett(float $gross): float
    {
        $tax = bcadd($this->getValue(), 100, self::CALCULATION_PRECISION);
        $nett = bcdiv(bcmul($gross, 100, self::CALCULATION_PRECISION), $tax, self::CALCULATION_PRECISION);

        return (float) round($nett, self::ROUND_PRECISION);
    }

    public function calculateNettInCents(int $gross): int
    {
        $tax = bcadd($this->getValue(), 100, self::CALCULATION_PRECISION);
        $nett = bcdiv(bcmul($gross, 100, self::CALCULATION_PRECISION), $tax, self::CALCULATION_PRECISION);

        return (int) round($nett, self::ROUND_CENTS_PRECISION);
    }

    private function validateTaxValue(int $tax): void
    {
        Assert::greaterThanEq($tax, 0, 'Given tax value should be greater than %2$s. Got: %s');
        Assert::lessThanEq($tax, 100, 'Given tax value should be less than %2$s. Got: %s');
    }
}
