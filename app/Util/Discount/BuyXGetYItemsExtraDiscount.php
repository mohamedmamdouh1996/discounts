<?php

namespace App\Util\Discount;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Order;

class BuyXGetYItemsExtraDiscount implements Discount {

    private int $minItems;
    private int $extraItems;
    private Category $category;

    public function isApplicable(Order $order): bool {
        // TODO: Implement isApplicable() method.
    }

    public function apply(Order $order): void {
        // TODO: Implement apply() method.
    }

    public function getDiscountName(): string {
        // TODO: Implement getDiscountName() method.
    }
}
