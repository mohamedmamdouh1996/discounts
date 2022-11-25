<?php

namespace App\Util\Discount;

use App\Models\Order;

interface Discount {

    public function isApplicable(Order $order): bool;

    public function apply(Order $order): void;

    public function getDiscountName(): string;
}
