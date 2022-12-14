<?php

namespace App\Models;

use App\Util\Discount\Discount;

class OrderItem {

    private string $productId;
    private string $quantity;
    private float $unitPrice;
    private float $totalPrice;
    private ?Discount $discount;

    public function __construct(string $productId, int $quantity, float $unitPrice, float $totalPrice) {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->totalPrice = $totalPrice;
        $this->discount = null;
    }

    public function getProductId() : string {
        return $this->productId;
    }

    public function getQuantity() : int {
        return $this->quantity;
    }

    public function increaseTotalQuantity(int $extraQuantity) : void {
        $this->quantity += $extraQuantity;
    }

    public function getTotalPrice() : float {
        return $this->totalPrice;
    }

    public function getUnitPrice() : float {
        return $this->unitPrice;
    }

    public function getDiscount() : ?Discount {
        return $this->discount;
    }

    public function setDiscount(Discount $discount) : void {
        $this->discount = $discount;
    }

    public function updateTotalPrice(float $newPrice) : void {
        $this->totalPrice = $newPrice;
    }

    public function toArray() {
        return [
            "product-id" => $this->productId,
            "quantity" => $this->quantity,
            "unit-price" => (string) $this->unitPrice,
            "total" => (string) $this->totalPrice,
            "discount" => $this->discount ? $this->discount->getDiscountName() : null,
        ];
    }
}
