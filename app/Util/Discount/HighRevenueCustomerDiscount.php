<?php

namespace App\Util\Discount;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Order;
use App\Repositories\CustomerRepository;

class HighRevenueCustomerDiscount implements Discount {

    private int $minRevenue;
    private int $offPercentage;
    protected CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $cr, $minRevenue = 1000,
        $offPercentage = 10
    ) {
        $this->minRevenue = $minRevenue;
        $this->offPercentage = $offPercentage;
        $this->customerRepository = $cr;
    }

    public function isApplicable(Order $order): bool {
        $customer = $this->customerRepository->find($order->getCustomerId());

        return $customer->getRevenue() >= $this->minRevenue;
    }

    public function apply(Order $order): void {
        $newPrice = $order->getTotal() -
            ($order->getTotal() * ($this->offPercentage / 100))
        ;
        $order->updateTotalPrice($newPrice);
        $order->setDiscount($this);
    }

    public function getDiscountName(): string {
        return "HighRevenueCustomerDiscount";
    }
}
