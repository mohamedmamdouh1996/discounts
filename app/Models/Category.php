<?php

namespace App\Models;

class Category extends Model {

    private string $id;

    public function __construct(string $id) {
        $this->id = $id;
    }

    public function getId() : string {
        return $this->id;
    }
}
