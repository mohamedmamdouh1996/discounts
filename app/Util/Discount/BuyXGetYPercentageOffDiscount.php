<?php

namespace App\Util\Discount;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Order;
use App\Repositories\ProductRepository;

class BuyXGetYPercentageOffDiscount implements Discount {

    private int $minItems;
    private int $offPercentage;
    private Category $category;
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $pr, Category $category, $minItems = 2, $offPercentage = 10) {
        $this->minItems = $minItems;
        $this->offPercentage = $offPercentage;
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
        $cheapestItem = null;
        $cheapestProduct = null;

        foreach ($order->getItems() as $item) {
            if ($this->isValidItem($item)) {
                $product = $this->productRepository->find($item->getProductId());
                if ($cheapestProduct === null || $product->getPrice() < $cheapestProduct->getPrice()) {
                    $cheapestItem = $item;
                    $cheapestProduct = $product;
                }
            }
        }

        $newPrice = $cheapestItem->getTotalPrice() - ($cheapestItem->getTotalPrice() * ($this->offPercentage / 100));
        $cheapestItem->updateTotalPrice($newPrice);
        $cheapestItem->setDiscount($this);

        $order->updateTotalPriceFromItems();
    }

    public function getDiscountName(): string {
        return "BuyXGetYPercentageOffDiscount";
    }

    private function isValidItem(OrderItem $orderItem) : bool {
        $product = $this->productRepository->find($orderItem->getProductId());
        $category = $product->getCategory();

        return $category->getId() === $this->category->getId()
            && $orderItem->getQuantity() >= $this->minItems;
    }
}
