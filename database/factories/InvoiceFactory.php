<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use App\Invoice;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Invoice::class, function (Faker $faker) {
    $customerCount = Customer::all()->count();
    $invoiceDate = $faker->dateTimeBetween('-3month', 'now')->format('Y-m-d');
    $paymentDueDate = $faker->dateTimeBetween('now', '+3month')->format('Y-m-d');

    return [
        'customer_id' => rand(1, $customerCount),
        'invoice_no' => Str::random(50),
        'invoice_date' => $invoiceDate,
        'payment_due_date' => $paymentDueDate,
        'remarks' => $faker->sentence(),
    ];
});
