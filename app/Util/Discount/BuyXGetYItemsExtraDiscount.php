<?php

namespace App\Util\Discount;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Order;
use App\Repositories\ProductRepository;

class BuyXGetYItemsExtraDiscount implements Discount {

    private int $minItems;
    private int $extraItems;
    private Category $category;
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $pr, Category $category, $minItems = 5, $extraItems = 1) {
        $this->minItems = $minItems;
        $this->extraItems = $extraItems;
        $this->category = $category;
        $this->productRepository = $pr;
    }

    public function isApplicable(Order $order): bool {
        foreach ($order->getItems() as $item) {
            if ($this->isValidItem($item)) {
                return true;
            }
        }

        return false;
    }

    public function apply(Order $order): void {
        foreach ($order->getItems() as $item) {
            if ($this->isValidItem($item)) {
                $freeItems = floor($item->getQuantity() / $this->minItems);
                $item->increaseTotalQuantity($this->extraItems * $freeItems);
                $item->setDiscount($this);
            }
        }
    }

    public function getDiscountName(): string {
        return "BuyXGetYItemsExtraDiscount";
    }

    private function isValidItem(OrderItem $orderItem) : bool {
        $product = $this->productRepository->find($orderItem->getProductId());
        $category = $product->getCategory();

        return $category->getId() === $this->category->getId()
            && $orderItem->getQuantity() >= $this->minItems;
    }
}
