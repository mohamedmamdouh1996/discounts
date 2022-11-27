<?php

namespace App\Models;


use App\Util\Discount\Discount;

class Order extends Model {

    public string $id;
    public string $customerId;
    public array $items = [];
    public string $total;
    public ?Discount $discount;

    public function __construct(string $id, string $customerId, array $items = [],
        float $total = 0
    ) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->items = $items;
        $this->total = $total;
        $this->discount = null;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getItems() : array {
        return $this->items;
    }

    public function getTotal() : float {
        return $this->total;
    }

    public function getCustomerId() : string {
        return $this->customerId;
    }

    public function updateTotalPriceFromItems() {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getTotalPrice();
        }

        $this->total = $total;

        if ($this->discount) {
            $this->discount->apply($this);
        }
    }

    public function updateTotalPrice(float $newPrice) : void {
        $this->total = $newPrice;
    }

    public function setDiscount(Discount $discount) : void {
        $this->discount = $discount;
    }

    public function toArray() {
        return [
            "id" => $this->id,
            "customer-id" => $this->customerId,
            "items" => $this->itemsToArray(),
            "total" => (string)$this->total,
            "discount" => $this->discount ? $this->discount->getDiscountName() : null,
        ];
    }

    public function itemsToArray() {
        $items = [];
        foreach($this->items as $item) {
            $items[] = $item->toArray();
        }

        return $items;
    }
}
