<?php

namespace App\Repositories\Memory;

use App\Models\Model;
use App\Models\Product;
use App\Repositories\ProductRepository;

class MemoryProductRepository implements ProductRepository {

    private array $products = [];

    public function find(string $id) : Product {
        return $this->products[$id];
    }

    public function add(Model $entity): void {
        $this->products[$entity->getId()] = $entity;
    }
}
