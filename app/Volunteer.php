<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Volunteer extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
   public function posts()
    {
        return $this->morphMany('App\post', 'users_post');
    }

    public function calendar()
    {
        return $this->hasMany('App\CalendarEvent');
    }

    public function interests()
    {
        return $this->belongsToMany('App\Interest');
    }

    public function calendar_events()
    {
        return $this->belongsToMany('App\CalendarEvent')->withPivot('hours_added');
    }
    public function photo()
    {
        return $this->morphMany('App\Photo', 'user');
    }
}
