<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $fillable = [
        'name'
    ];
    public function users()
    {
    	return $this->belongsToMany('App\Volunteer')->withTimestamps();
    }
}