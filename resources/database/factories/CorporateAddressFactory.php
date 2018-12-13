<?php

use Faker\Generator as Faker;
use Joesama\Project\Organization\CorporateAddress;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(CorporateAddress::class, function (Faker $faker) {
    return [
        'line_1' => $faker->address,
        'postcode' => $faker->postcode,
    ];
});
