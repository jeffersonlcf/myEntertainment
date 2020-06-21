<?php

namespace App\Http\Controllers;

use Image;
use App\Me;
use App\Classes\Search\Imdb;
use Illuminate\Http\Request;


class MeController extends Controller
{
    public function show(Me $me)
    {
        return view('me.show', ['me' => $me]);
    }

    public function store_from_search(Request $request)
    {
        $imdb = new Imdb($request);
       
        $data = $imdb->getResults()->first();
        
        $me = Me::updateOrCreate(
            ['imdb_id' => $data->id],
            ['title' => $data->title, 'year' => $data->year, 'type' => $data->type]
        );

        return redirect()->route('me.show', ['me' => $me->id]);

    }

    public function image(){

        $originalImage = file_get_contents('https://m.media-amazon.com/images/M/MV5BNzQzOTk3OTAtNDQ0Zi00ZTVkLWI0MTEtMDllZjNkYzNjNTc4L2ltYWdlXkEyXkFqcGdeQXVyNjU0OTQ0OTY@._V1_.jpg');
        $thumbnailImage = Image::make($originalImage);
        $thumbnailPath = public_path().'/files/thumbnail/';
        $originalPath = public_path().'/files/images/';
        $thumbnailImage->save($originalPath.time().'test.jpg');
        $thumbnailImage->resize(182, 268);
        $thumbnailImage->save($thumbnailPath.time().'test.jpg');
    }

    public function get_information_from_page($url = null)
    {
        $img = Image::make('foo.jpg')->resize(182, 268);

        $url = 'https://www.imdb.com/title/tt0133093';

        $dom = new \DOMDocument();
        $dom->loadHTMLFile($url);
        $finder = new \DOMXPath($dom);

        $jsonScripts = $finder->query( '//script[@type="application/ld+json"]' );
        $json = trim( $jsonScripts->item(0)->nodeValue );

        $data = json_decode(str_replace('@t', 't', $json));
        $image = str_replace('.jpg', 'UX182_CR0,0,182,268_AL_.jpg', $data->image);

        return $data;
    }
}
