<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Me extends Model
{
    protected $fillable = ['imdb_id', 'title', 'year', 'type'];
    protected $table = 'me';

    protected $appends = array('thumbnail');

    public function image()
    {
        return $this->hasMany('App\Image');
    }

    public function getThumbnailAttribute()
    {
        $filename = $this->image()
        ->where('main',true)
        ->first()
        ->filename;

        return asset('storage/files/thumbnail/'.$this->id.'/'.$filename);
    }

}
