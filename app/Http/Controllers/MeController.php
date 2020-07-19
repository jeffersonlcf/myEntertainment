<?php

namespace App\Http\Controllers;

use App\Me;
use App\Classes\Search\Imdb as ImdbSearch;
use App\Classes\Files\Image;
use App\Rating;
use App\Season;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function show(Me $me)
    {
        $user = Auth::user();

        $ratings = $me->ratings()->where('user_id', $user->id)->first();
        $like = $ratings->like ?? null;
        return view('me.show', ['me' => $me, 'like' => $like]);
    }

    public function store_from_search(Request $request)
    {
        $imdb = new ImdbSearch($request);
       
        $data = $imdb->getResults()->first();
        
        $me = Me::updateOrCreate(
            ['imdb_id' => $data->id],
            ['title' => $data->title, 'year' => $data->year, 'type' => $data->type]
        );

        $img = new Image($me, $data->image);

        $img->store();

        return redirect()->route('me.show', ['me' => $me->id]);

    }

    public function refresh(Me $me)
    {
        $url = 'https://www.imdb.com/title/'.$me->imdb_id;

        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTMLFile($url);
        $finder = new \DOMXPath($dom);

        $seasons_node_list = $finder->query( '//a[starts-with(@href,"/title/'.$me->imdb_id.'/episodes?season")]' );

        for ($i = 1; $i <= $seasons_node_list->length; $i++) {
            $season = Season::updateOrCreate(
                ['me_id' => $me->id, 'season' => $i]
            );
        }

        return back();
    }

    public function get_information_from_page($url = null)
    {
        //$img = Image::make('foo.jpg')->resize(182, 268);

        $url = 'https://www.imdb.com/title/tt8001788';

        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTMLFile($url);
        $finder = new \DOMXPath($dom);

        $seasons = $finder->query( '//a[starts-with(@href,"/title/tt8001788/episodes?season")]' );
        return $seasons->length;

        $jsonScripts = $finder->query( '//script[@type="application/ld+json"]' );
        $json = trim( $jsonScripts->item(0)->nodeValue );

        $data = json_decode(str_replace('@t', 't', $json));
        $image = str_replace('.jpg', 'UX182_CR0,0,182,268_AL_.jpg', $data->image);

        return $data;
    }

    public function like(Request $request, Me $me)
    {
        $rating = Rating::updateOrCreate(
            ['rateable_type' => 'me', 'rateable_id' => $me->id, 'user_id' => Auth::user()->id],
            ['like' => $request->like]
        );

        return response()->json([
            'message' => 'success',
            'like' => $rating->like,
        ]);
    }
}
