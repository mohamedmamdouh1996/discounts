<?php

namespace App\Handlers;

use App\Models\Order;
use Illuminate\Container\RewindableGenerator;

class DiscountHandler {

    public RewindableGenerator $discounts;

    public function __construct(RewindableGenerator $discounts) {
        $this->discounts = $discounts;
    }

    public function applyDiscounts(Order $order) {
        foreach ($this->discounts as $discount) {
            if ($discount->isApplicable($order)) {
                $discount->apply($order);
            }
        }

        return $order;
    }
}
