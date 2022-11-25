<?php

namespace App\Util\Discount;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Order;

class BuyXGetYPercentageOffDiscount implements Discount {

    private int $minItems;
    private int $offPercentage;
    private Category $category;

    public function isApplicable(Order $order): bool {

    }

    public function apply(Order $order): void {

    }

    public function getDiscountName(): string {

    }
}
