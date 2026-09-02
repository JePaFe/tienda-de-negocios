<?php

namespace App\Services;

class TaxCalculator
{
    public function calculate(float $amount): float
    {
        return $amount * 0.21;
    }
}
