<?php

namespace App\Models;

class Customer extends Model {

    private string $id;
    private string $name;
    private string $since;
    private float $revenue;

    public function __construct(string $id, string $name, string $since, float $revenue) {
        $this->id = $id;
        $this->name = $name;
        $this->since = $since;
        $this->revenue = $revenue;
    }

    public function getId() : string {
        return $this->id;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getSince() : string {
        return $this->since;
    }

    public function getRevenue() : float {
        return $this->revenue;
    }
}
