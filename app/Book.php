<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function category()
    {
        return $this->belongsTo(\App\Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(\App\Tag::class);
    }

    public function author()
    {
        return $this->belongsTo(\App\Author::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Comment::class);
    }
}
