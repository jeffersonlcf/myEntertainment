<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['rateable_type', 'rateable_id', 'user_id', 'like', 'emotions', 'stars'];

    protected $casts = [
        'emotions' => 'json',
    ];

    public function rateable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function ratings()
    {
        return $this->morphMany('App\Models\Rating', 'rateable');
    }
}
