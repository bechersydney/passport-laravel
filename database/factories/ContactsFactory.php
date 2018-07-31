<?php

use Faker\Generator as Faker;

$factory->define(App\Contacts::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'phone_number'=>$faker->phoneNumber,
        'user_id'=>App\User::all()->random()->id
    ];
});
