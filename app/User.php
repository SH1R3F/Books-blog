<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'confirm_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function isConfirmed()
    {
        return is_null($this->confirm_token);
    }

    public function confirm()
    {
        $this->confirm_token = null;
        $this->save();
    }

    public function book()
    {
        return $this->hasMany(\App\Book::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Comment::class);
    }

}
