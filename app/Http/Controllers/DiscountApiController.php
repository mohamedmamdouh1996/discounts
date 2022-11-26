<?php

namespace App\Http\Controllers;

use App\Handlers\DiscountHandler;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;

class DiscountApiController extends Controller {

    public function __construct(DiscountHandler $discountHandler) {
        $this->discountHandler = $discountHandler;
    }

    public function applyDiscounts(Request $request) {

        // Request Validation
        $order = $this->formOrderFromRequest($request->all());

        $newOrder = $this->discountHandler->applyDiscounts($order);

        return $newOrder->toArray();
    }


    private function formOrderFromRequest($data = []) : Order {
        $items = [];

        foreach ($data["items"] as $item) {
            $items[] = new OrderItem($item["product-id"], $item["quantity"], $item["unit-price"], $item["total"]);
        }

        return new Order($data["id"], $data["customer-id"], $items, $data["total"]);
    }
}
