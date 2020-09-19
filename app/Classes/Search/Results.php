<?php

namespace App\Classes\Search;

use App\Models\Me;

class Results 
{
    public $id;
    public $imdbId;
    public $title;
    public $year;
    public $type;
    public $image;
    public $showUrl;

    public function setShowUrl($url = null)
    {
        $me = Me::where('imdb_id',$this->imdbId)->first();
        if($me !== null){
            $url = route('me.show', ['me' => $me->id]);
        }

        $this->showUrl = $url;
    }

    public function setImageUrl($url = null)
    {
        $me = Me::where('imdb_id',$this->imdbId)->first();
        if($me !== null){
            $url = $me->thumbnail;
        }

        $this->image = $url;

    }
}


