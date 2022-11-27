<?php

namespace App\Providers;

use App\Handlers\DiscountHandler;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Repositories\CustomerRepository;
use App\Repositories\Memory\MemoryCustomerRepository;
use App\Repositories\Memory\MemoryProductRepository;
use App\Repositories\ProductRepository;
use App\Util\Discount\BuyXGetYItemsExtraDiscount;
use App\Util\Discount\BuyXGetYPercentageOffDiscount;
use App\Util\Discount\HighRevenueCustomerDiscount;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductRepository::class, function ($app) {
            $repo =  new MemoryProductRepository();
            $json = file_get_contents(__DIR__ . '/../../products.json');
            $products = json_decode($json, true);

            foreach ($products as $product) {
                $repo->add(
                    new Product($product["id"], $product["description"], (float) $product["price"],
                        new Category((int)$product["category"])
                    )
                );
            }

            return $repo;
        });

        $this->app->bind(CustomerRepository::class, function ($app) {
            $repo =  new MemoryCustomerRepository();
            $json = file_get_contents(__DIR__ . '/../../customers.json');
            $customers = json_decode($json, true);

            foreach ($customers as $customer) {
                $repo->add(
                    new Customer($customer["id"], $customer["name"],
                        $customer["since"], $customer["revenue"]
                    )
                );
            }

            return $repo;
        });

        $this->app->bind(HighRevenueCustomerDiscount::class, function ($app) {
            return new HighRevenueCustomerDiscount(
                $app->make(CustomerRepository::class),
                1000,
                10
            );
        });

        $this->app->bind(BuyXGetYPercentageOffDiscount::class, function ($app) {
            return new BuyXGetYPercentageOffDiscount(
                $app->make(ProductRepository::class),
                new Category(1),
                2,
                10
            );
        });


        $this->app->bind(BuyXGetYItemsExtraDiscount::class, function ($app) {
            return new BuyXGetYItemsExtraDiscount(
                $app->make(ProductRepository::class),
                new Category(2),
                5,
                1
            );
        });

        $this->app->tag([
            HighRevenueCustomerDiscount::class,
            BuyXGetYPercentageOffDiscount::class,
            BuyXGetYItemsExtraDiscount::class
        ], "discounts");

        $this->app->bind(DiscountHandler::class, function ($app) {
            return new DiscountHandler($app->tagged("discounts"));
        });
    }
}
