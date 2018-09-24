<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
    $word = $faker->word;
    return [
        'title' => $word,
        'slug'  => str_slug($word)
    ];
});
