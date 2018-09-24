<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    $title = $faker->sentence;
    $count = \App\Book::where('slug', 'like', '%' . str_slug($title) . '%')->count();
    if($count > 0){
        $slug = str_slug($title) . '-' . $count;
    }else{
        $slug = str_slug($title);
    }

    return [
        'book_name' => $title,
        'thumbnail' => $faker->image(storage_path('app/public/thumbnails'), 200, 300, null, false),
        'slug' => $slug,
        'description' => $faker->paragraphs(rand(5, 8), true),
        'category_id' => rand(1, 50),
        'author_id' => rand(1, 50),
        'user_id' => rand(1, 4)
    ];
});
