<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Photo;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Photo::class, function (Faker $faker) {
    return [
        'id' => Str::random(32),
        'user_id' => fn () => factory(App\User::class)->create()->id,
        'filename' => Str::random(32) . '.jpg',
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
