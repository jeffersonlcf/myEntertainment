<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function me()
    {
        return $this->belongsTo('App\Me');
    }
}
