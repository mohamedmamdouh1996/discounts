<?php

namespace App\Repositories\Memory;

use App\Models\Customer;
use App\Models\Model;
use App\Repositories\CustomerRepository;
use App\Repositories\Repository;

class MemoryCustomerRepository implements CustomerRepository {

    private array $customers = [];

    public function find(string $id) : Customer {
        return $this->customers[$id];
    }

    public function add(Model $entity) : void {
        $this->customers[$entity->getId()] = $entity;
    }
}
