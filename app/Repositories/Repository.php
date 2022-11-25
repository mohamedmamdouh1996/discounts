<?php

namespace App\Repositories;

use App\Models\Model;

interface Repository {

    public function find(string $id) : Model;

    public function add(Model $entity) : void;

}
