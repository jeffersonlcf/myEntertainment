<?php

namespace App\Http\Controllers;

use App\Models\Me;
use App\Classes\Search\Imdb as ImdbSearch;
use App\Classes\Files\Image;
use App\Models\Rating;
use App\Models\Season;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeController extends Controller
{
    public function show(Me $me)
    {
        $like = null;
        $emotions = [];
        $stars = 0;
        $user = Auth::user();
        if(isset($user)){
            $ratings = $me->ratings()->where('user_id', $user->id)->first();
            $like = $ratings->like ?? null;
            $emotions = $ratings->emotions ?? [];
            $stars = $ratings->stars ?? 0;
        }

        return view('me.show', compact('me', 'like', 'emotions', 'stars'));
    }

    public function store_from_search(Request $request)
    {
        $imdb = new ImdbSearch($request);
       
        $data = $imdb->getResults()->first();
        
        try {
            DB::beginTransaction();

            $me = Me::updateOrCreate(
                ['imdb_id' => $data->id],
                ['title' => $data->title, 'year' => $data->year, 'type' => $data->type]
            );

            $img = new Image($me, $data->image);

            $img->store();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

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

    public function emotions(Request $request, Me $me)
    {
        $rating = Rating::updateOrCreate(
            ['rateable_type' => 'me', 'rateable_id' => $me->id, 'user_id' => Auth::user()->id],
            ['emotions' => $request->emotions]
        );

        return response()->json([
            'message' => 'success',
            'emotions' => $rating->emotions,
        ]);
    }

    public function stars(Request $request, Me $me)
    {
        $rating = Rating::updateOrCreate(
            ['rateable_type' => 'me', 'rateable_id' => $me->id, 'user_id' => Auth::user()->id],
            ['stars' => $request->stars]
        );

        return response()->json([
            'message' => 'success',
            'stars' => $rating->stars,
        ]);
    }
}
