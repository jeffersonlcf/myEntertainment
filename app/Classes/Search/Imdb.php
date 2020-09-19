<?php

namespace App\Classes\Search;

use Illuminate\Support\Str;

class Imdb 
{
    public $request;
    public $url;
    public $data;

    public function __construct($request) {
        $this->request = $request;
        $this->imdbUrl = $this->getImdbUrl();
        $this->data = $this->getData();
    }

    public function getResults()
    {
        $results = collect();

        if (!empty($this->data->d)) {
            foreach ($this->data->d as $item){

                $type = $this->getType($item);
                
                if($type !== null && isset($item->y)){

                    $url = route('me.search.store',['q' => $item->id]);
                    $imageUrl = $this->getImage($item);

                    $result = new Results();
                    $result->imdbId = $item->id;
                    $result->title = $item->l;
                    $result->year = $item->y;
                    $result->type = $type;
                    $result->typeName = trans('me.type.'.$type);
                    $result->setImageUrl($imageUrl);
                    $result->setShowUrl($url);

                    $results->push($result);
                }
            }
        }

        return $results;
    }
    

    private function getData()
    {
        $json = file_get_contents($this->imdbUrl);
        return json_decode($json);
    }

    private function getImdbUrl()
    {

        $string = Str::clean($this->request->q); // Macroable in AppServiceProvider

        return "https://v2.sg.media-imdb.com/suggestion/".$string[0]."/".$string.".json";

    }

    private function getImage($item)
    {
        $image = '';
        if(!empty($item->i)){
            $image = $item->i->imageUrl;
        }
        return $image;
    }

    private function getType($item) {
        $type = null;
        if(!empty($item->q)){
            switch ($item->q) {
                case 'short':
                case 'feature':
                    $type = 1;
                    break;
                case 'TV series':
                case 'TV mini-series':
                    $type = 2;
                    break;
            }
        }
        return $type;
    }
    
}


