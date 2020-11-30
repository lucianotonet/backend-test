<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Campaign;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Campaign::class, function (Faker $faker) {
    return [
        'name' => $faker->userName,
        'timezone' => $faker->timezone,
        'targeting' => $faker->boolean,
        'segmentation' => $faker->boolean,
        'starts_at' => now()->startOfDay()->format('d-m-Y H:i'),
        'ends_at' => now()->addMonth()->endOfDay()->format('d-m-Y H:i:s'),
    ];
});
