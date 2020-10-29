<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\InvoiceItem;
use App\Product;
use Faker\Generator as Faker;

$factory->define(InvoiceItem::class, function (Faker $faker) {
    $product = factory(Product::class)->create();
    $quantity = $faker->numberBetween(0, 99999999) / 100;
    $amount = ceil($product->price * $quantity);

    return [
        'invoice_id' => function() {
            return factory(Invoice::class)->create()->id;
        },
        'item_id' => 1,
        'product_id' => $product->id,
        'quantity' => $quantity,
        'amount' => $amount,
        'remarks' => substr($faker->sentence(), 1, 50),
    ];
});
