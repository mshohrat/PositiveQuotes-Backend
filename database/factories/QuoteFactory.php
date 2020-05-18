<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Quote::class, function (Faker $faker) {
    return [
        'text' => $faker->text,
        'author' => $faker->name(),
        'active' => true,
    ];
});
