<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use App\Customer;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'address' => $faker->buildingNumber . ' ' . $faker->streetName,
        'address2' => $faker->secondaryAddress,
        'city' => $faker->city,
        'state' => $faker->stateAbbr,
        'zip' => $faker->postcode
    ];
});

$factory->state(Address::class, 'belongsToCustomer', [
    'customer_id' => function () {
        return factory(Customer::class)->create()->id;
    },
]);

$factory->state(Address::class, 'isBillingAddress', [
    'billing_address' => true,
]);

$factory->state(Address::class, 'notBillingAddress', [
    'billing_address' => false,
]);
