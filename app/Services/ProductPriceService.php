<?php

namespace App\Services;

use App\Services\TaxCalculator;

class ProductPriceService
{
    public function __construct(
        private TaxCalculator $taxCalculator
    ) {}

    public function finalPrice(float $price): float
    {
        $tax = $this->taxCalculator->calculate($price);

        return $price + $tax;
    }
}
