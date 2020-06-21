<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Me extends Model
{
    protected $fillable = ['imdb_id', 'title', 'year', 'type'];
    protected $table = 'me';
}
