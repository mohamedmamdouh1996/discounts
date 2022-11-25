<?php

namespace App\Models;


class Order extends Model {

    public string $id;
    public string $customerId;
    public array $items = [];
    public string $total;
    public ?string $discount; // TODO ADD DISCOUNT

    public function __construct($id, $customerId, $items, $total) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->items = $items;
        $this->total = $total;
        $this->discount = null;
    }

    // Getters
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
}
