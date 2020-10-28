<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Unit;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Unit::class, function (Faker $faker) {
    return [
        'name' => Str::random(10),
    ];
});
