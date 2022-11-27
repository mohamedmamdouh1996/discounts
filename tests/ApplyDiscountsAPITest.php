<?php

namespace Tests;

use Tests\TestCase;


class ApplyDiscountsAPITest extends TestCase {

    public function testNoDiscountApplied() {
        $requestBody = [
            "id"          => "1",
            "customer-id" => "1",
            "items"       => [
                [
                    "product-id" => "B101",
                    "quantity"   => "1",
                    "unit-price" => "4.99",
                    "total"      => "4.99",
                ],
            ],
            "total"       => "4.99",
        ];

        $this->post("/api/apply-discount", $requestBody);

        $this->assertEquals(
            200, $this->response->getStatusCode()
        );

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals([
            "id"               => "1",
            "customer-id"      => "1",
            "items"            => [
                [
                    "product-id"       => "B101",
                    "quantity"         => "1",
                    "unit-price"       => "4.99",
                    "total"            => "4.99",
                    "discount" => null,
                ],
            ],
            "total"            => "4.99",
            "discount" => null,
        ], $response);
    }

    public function testBuyFiveGetOneFreeApplied() {
        $requestBody = [
            "id"          => "1",
            "customer-id" => "1",
            "items"       => [
                [
                    "product-id" => "B102",
                    "quantity"   => "10",
                    "unit-price" => "4.99",
                    "total"      => "49.9",
                ],
            ],
            "total"       => "49.9",
        ];

        $this->post("/api/apply-discount", $requestBody);

        $this->assertEquals(
            200, $this->response->getStatusCode()
        );

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals([
            "id"          => "1",
            "customer-id" => "1",
            "items"       => [
                [
                    "product-id" => "B102",
                    "quantity"   => "12",
                    "unit-price" => "4.99",
                    "total"      => "49.9",
                    "discount"   => "BuyXGetYItemsExtraDiscount",
                ],
            ],
            "total"       => "49.9",
            "discount"    => null,
        ], $response);
    }

    public function testTwentyPercentageOffCheapest() {
        $requestBody = [
            "id"          => "1",
            "customer-id" => "1",
            "items"       => [
                [
                    "product-id" => "A101",
                    "quantity"   => "2",
                    "unit-price" => "9.75",
                    "total"      => "19.50",
                ],
            ],
            "total"       => "19.50",
        ];

        $this->post("/api/apply-discount", $requestBody);

        $this->assertEquals(
            200, $this->response->getStatusCode()
        );

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals([
            "id"               => "1",
            "customer-id"      => "1",
            "items"            => [
                [
                    "product-id"       => "A101",
                    "quantity"         => "2",
                    "unit-price"       => "9.75",
                    "total"            => "17.55",
                    "discount" => "BuyXGetYPercentageOffDiscount",
                ],
            ],
            "total"            => "17.55",
            "discount" => null,
        ], $response);
    }

    public function testHRDiscountApplied() {
        $requestBody = [
            "id"          => "1",
            "customer-id" => "2", // +1000 Revenue Customer
            "items"       => [
                [
                    "product-id" => "B103",
                    "quantity"   => "2",
                    "unit-price" => "4.99",
                    "total"      => "9.98",
                ],
            ],
            "total"       => "9.98",
        ];

        $this->post("/api/apply-discount", $requestBody);

        $this->assertEquals(
            200, $this->response->getStatusCode()
        );

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals([
            "id"               => "1",
            "customer-id"      => "2",
            "items"            => [
                [
                    "product-id"       => "B103",
                    "quantity"         => "2",
                    "unit-price"       => "4.99",
                    "total"            => "9.98",
                    "discount" => null,
                ],
            ],
            "total"            => "8.982",
            "discount" => "HighRevenueCustomerDiscount",
        ], $response);
    }

    public function testTwoDiscounts() {
        $requestBody = [
            "id"          => "1",
            "customer-id" => "2",
            "items"       => [
                [
                    "product-id" => "B102",
                    "quantity"   => "10",
                    "unit-price" => "4.99",
                    "total"      => "49.9",
                ],
            ],
            "total"       => "49.9",
        ];

        $this->post("/api/apply-discount", $requestBody);

        $this->assertEquals(
            200, $this->response->getStatusCode()
        );

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals([
            "id"          => "1",
            "customer-id" => "2",
            "items"       => [
                [
                    "product-id" => "B102",
                    "quantity"   => "12",
                    "unit-price" => "4.99",
                    "total"      => "49.9",
                    "discount"   => "BuyXGetYItemsExtraDiscount",
                ],
            ],
            "total"       => "44.91",
            "discount"    => "HighRevenueCustomerDiscount",
        ], $response);
    }

    public function testTwentyPercentageOffCheapestTwoItems() {
        $requestBody = [
            "id"          => "1",
            "customer-id" => "1",
            "items"       => [
                [
                    "product-id" => "A101",
                    "quantity"   => "2",
                    "unit-price" => "9.75",
                    "total"      => "19.50",
                ],
                [
                    "product-id" => "A102",
                    "quantity"   => "1",
                    "unit-price" => "49.5",
                    "total"      => "49.5",
                ],
            ],
            "total"       => "69.00",
        ];

        $this->post("/api/apply-discount", $requestBody);

        $this->assertEquals(
            200, $this->response->getStatusCode()
        );

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals([
            "id"               => "1",
            "customer-id"      => "1",
            "items"            => [
                [
                    "product-id"       => "A101",
                    "quantity"         => "2",
                    "unit-price"       => "9.75",
                    "total"            => "17.55",
                    "discount" => "BuyXGetYPercentageOffDiscount",
                ],
                [
                    "product-id" => "A102",
                    "quantity"   => "1",
                    "unit-price" => "49.5",
                    "total"      => "49.5",
                    "discount" => null,
                ],
            ],
            "total"            => "67.05",
            "discount" => null,
        ], $response);
    }

    public function testTwentyPercentageOffCheapestTwoItemsAndHR() {
        $requestBody = [
            "id"          => "1",
            "customer-id" => "2",
            "items"       => [
                [
                    "product-id" => "A101",
                    "quantity"   => "2",
                    "unit-price" => "9.75",
                    "total"      => "19.50",
                ],
                [
                    "product-id" => "A102",
                    "quantity"   => "1",
                    "unit-price" => "49.5",
                    "total"      => "49.5",
                ],
            ],
            "total"       => "69.00",
        ];

        $this->post("/api/apply-discount", $requestBody);

        $this->assertEquals(
            200, $this->response->getStatusCode()
        );

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals([
            "id"               => "1",
            "customer-id"      => "2",
            "items"            => [
                [
                    "product-id"       => "A101",
                    "quantity"         => "2",
                    "unit-price"       => "9.75",
                    "total"            => "17.55",
                    "discount" => "BuyXGetYPercentageOffDiscount",
                ],
                [
                    "product-id" => "A102",
                    "quantity"   => "1",
                    "unit-price" => "49.5",
                    "total"      => "49.5",
                    "discount" => null,
                ],
            ],
            "total"            => "60.345",
            "discount" => "HighRevenueCustomerDiscount",
        ], $response);
    }

    public function testMixAllDiscounts() {
        $requestBody = [
            "id"          => "1",
            "customer-id" => "2",
            "items"       => [
                [
                    "product-id" => "B102",
                    "quantity"   => "10",
                    "unit-price" => "4.99",
                    "total"      => "49.9",
                ],
                [
                    "product-id" => "A101",
                    "quantity"   => "2",
                    "unit-price" => "9.75",
                    "total"      => "19.50",
                ],
                [
                    "product-id" => "A102",
                    "quantity"   => "1",
                    "unit-price" => "49.5",
                    "total"      => "49.5",
                ],
            ],
            "total"       => "69.00",
        ];

        $this->post("/api/apply-discount", $requestBody);

        $this->assertEquals(
            200, $this->response->getStatusCode()
        );

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals([
            "id"               => "1",
            "customer-id"      => "2",
            "items"            => [
                [
                    "product-id" => "B102",
                    "quantity"   => "12",
                    "unit-price" => "4.99",
                    "total"      => "49.9",
                    "discount" => "BuyXGetYItemsExtraDiscount",
                ],
                [
                    "product-id"       => "A101",
                    "quantity"         => "2",
                    "unit-price"       => "9.75",
                    "total"            => "17.55",
                    "discount" => "BuyXGetYPercentageOffDiscount",
                ],
                [
                    "product-id" => "A102",
                    "quantity"   => "1",
                    "unit-price" => "49.5",
                    "total"      => "49.5",
                    "discount" => null,
                ],
            ],
            "total"            => "110.245",
            "discount" => "HighRevenueCustomerDiscount",
        ], $response);
    }


}
