<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = ['me_id', 'season'];

    public function me()
    {
        return $this->belongsTo('App\Models\Me');
    }

    public function ratings()
    {
        return $this->morphMany('App\Models\Rating', 'rateable');
    }
}
