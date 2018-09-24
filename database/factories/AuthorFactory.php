<?php

use Faker\Generator as Faker;

$factory->define(App\Author::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'author_name' => $name,
        'slug' => str_slug($name)
    ];
});
