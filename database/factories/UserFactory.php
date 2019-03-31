<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(User::class, function (Faker $faker) {
    static $seq = 0;

    $seq++;

    return [
        'name'               => $faker->name,
        'type_kind_2'        => $seq % 2,
        'type_kind_10'       => $seq % 10,
        'seq'                => $seq,
        'type_kind_2_index'  => $seq % 2,
        'type_kind_10_index' => $seq % 10,
        'seq_index'          => $seq,
    ];
});
