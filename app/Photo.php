<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function user()
    {
        return $this->morphTo();
    }

     protected $casts = [
        'shared' => 'boolean',
    ];
    
}
