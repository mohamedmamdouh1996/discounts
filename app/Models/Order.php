<?php

namespace App\Models;


use App\Util\Discount\Discount;

class Order extends Model {

    public string $id;
    public string $customerId;
    public array $items = [];
    public string $total;
    public ?Discount $discount;

    public function __construct(string $id, string $customerId, array $items = [], float $total = 0) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->items = $items;
        $this->total = $total;
        $this->discount = null;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getTotal() : float {
        return $this->total;
    }

    public function getItems() : array {
        return $this->items;
    }

    public function getCustomerId() : string {
        return $this->customerId;
    }

    public function getDiscount() : ?Discount {
        return $this->discount;
    }
}
