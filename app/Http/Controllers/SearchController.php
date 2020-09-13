<?php

namespace App\Http\Controllers;

use App\Classes\Search\Imdb;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search_local(Request $request)
    {
        
        $imdb = new Imdb($request);

        return [
            'query' => $request->q,
            'results' => $imdb->getResults(),

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
