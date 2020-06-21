<?php

namespace App\Classes\Search;

use App\Me;
use Illuminate\Support\Facades\DB;

class Results 
{
    public $id;
    public $title;
    public $year;
    public $type;
    public $image;
    public $showUrl;

    public function __construct($data = null) {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->year = $data['year'];
        $this->type = $data['type'];
        $this->image = $data['image'];
    }

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


