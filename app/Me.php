<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Me extends Model
{
    protected $fillable = ['imdb_id', 'title', 'year', 'type'];
    protected $table = 'me';

    protected $appends = array('thumbnail');

    public function getThumbnailAttribute()
    {
        $filename = $this->images()
        ->where('main',true)
        ->first()
        ->filename;

        return asset('storage/files/thumbnail/'.$this->id.'/'.$filename);
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function seasons()
    {
        return $this->hasMany('App\Season');
    }

}
