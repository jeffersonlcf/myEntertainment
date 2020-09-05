<?php

namespace App\Classes\Search;

use App\Models\Me;

class Results 
{
    public $id;
    public $title;
    public $year;
    public $type;
    public $image;
    public $showUrl;

    public function setShowUrl($url)
    {
        $me = Me::where('imdb_id',$this->id)->first();
        if($me !== null){
            $url = route('me.show', ['me' => $me->id]);
        }

        $this->showUrl = $url;
    }

    public function setImageUrl($url)
    {
        $me = Me::where('imdb_id',$this->id)->first();
        if($me !== null){
            $url = $me->thumbnail;
        }

        $this->image = $url;

    }
}


