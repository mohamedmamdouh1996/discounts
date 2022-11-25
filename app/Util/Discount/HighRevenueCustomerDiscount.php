<?php

namespace App\Util\Discount;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Order;

class HighRevenueCustomerDiscount implements Discount {

    private int $minRevenue;
    private int $offPercentage;


    public function isApplicable(Order $order): bool {

    }

    public function apply(Order $order): void {

    }

    public function getDiscountName(): string {

    }
}
