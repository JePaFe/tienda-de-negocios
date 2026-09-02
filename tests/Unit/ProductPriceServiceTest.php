<?php

namespace Tests\Unit;

use App\Services\TaxCalculator;
use App\Services\ProductPriceService;
use PHPUnit\Framework\TestCase;

class ProductPriceServiceTest extends TestCase
{
    // public function test_final_price_includes_tax(): void {
    //     $taxCalculator = new TaxCalculator();

    //     $productPriceService = new ProductPriceService($taxCalculator);

    //     $result = $productPriceService->finalPrice(100);

    //     $this->assertEquals(121, $result);
    // }

    public function test_final_price_includes_tax(): void {
        $taxCalculator = $this->createMock(TaxCalculator::class);

        $taxCalculator
            ->expects($this->once())
            ->method('calculate')
            ->with(100.0)
            ->willReturn(21.0);

        $productPriceService = new ProductPriceService($taxCalculator);

        $result = $productPriceService->finalPrice(100);

        $this->assertEquals(121, $result);
    }
}
