<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\Unit;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $count = Unit::all()->count();
    return [
        'name' => $faker->word(),
        'price' => rand(1, 999) * 100,
        'unit_id' => rand(1, $count),
        'summary' => $faker->sentence(),
    ];
});
