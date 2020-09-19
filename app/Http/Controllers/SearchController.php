<?php

namespace App\Http\Controllers;

use App\Classes\Search\Imdb;
use App\Classes\Search\Results;
use App\Models\Me;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search_local(Request $request)
    {
        $query = $request->q;
        $results = collect();

        $me = Me::where('title','like', $query.'%')->get();

        foreach ($me as $item) {
            $result = new Results();
            $result->id = $item->imdb_id;
            $result->title = $item->title;
            $result->year = $item->year;
            $result->type = $item->type;
            $result->typeName = trans('me.type.'.$item->type);
            $result->setImageUrl();
            $result->setShowUrl();
            $results->push($result);
        }
        
        return [
            'query' => $request->q,
            'results' => $results,

        ];
    }

    public function search_remote(Request $request)
    {
        
        $imdb = new Imdb($request);

        return [
            'query' => $request->q,
            'results' => $imdb->getResults(),

        ];
    }
}
