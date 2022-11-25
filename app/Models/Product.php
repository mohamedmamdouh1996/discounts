<?php

namespace App\Models;

class Product extends Model {

    private string $id;
    private string $description;
    private float $price;
    private Category $category;

    public function __construct(string $id, string $description, float $price, Category $category) {
        $this->id = $id;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
    }

    public function getId() : string {
        return $this->id;
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function getPrice() : float {
        return $this->price;
    }

    public function getCategory() : Category {
        return $this->category;
    }
}
