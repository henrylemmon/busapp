<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use App\Invoice;
use App\Customer;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'customer_id' => 2,
        'billing_address_id' => 4,
        'job_address_id' => 6,
        'sales_person' => $faker->firstName,
        'billing_date' => str_replace('-', '_', $faker->date('Y-m-d')),
        'description' => $faker->text(25),
        'cost_description' => $faker->text(10),
        'completed' => true,
        'paid' => false,
        'total' => '2500.00'
    ];
});
