<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Organization extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
protected $table ='organizations';

    protected $fillable = [
        'organization', 'firstName', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function calendar()
    {
        return $this->hasMany('App\CalendarEvent');
    }
     public function posts()
    {
        return $this->morphMany('App\post', 'users_post');
    }
     public function photo()
    {
        return $this->morphMany('App\Photo', 'user');
    }
}
