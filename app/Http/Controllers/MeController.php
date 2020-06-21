<?php

namespace App\Http\Controllers;

use Image as ImageIntervention;
use App\Me;
use App\Image;
use App\Classes\Search\Imdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $this->save_image($me, $data->image);

        return redirect()->route('me.show', ['me' => $me->id]);

    }

    public function save_image(Me $me, $path){

        $filename = basename($path);
        $thumbnailImage = ImageIntervention::make($path);
        $thumbnailPath = 'public/files/thumbnail/'.$me->id.'/';
        $originalPath = 'public/files/images/'.$me->id.'/';

        if (!Storage::exists($originalPath)) {
            Storage::makeDirectory($originalPath, 0775, true, true);
            $thumbnailImage->save(storage_path('app/'.$originalPath.$filename));
        }

        if (!Storage::exists($thumbnailPath)) {
            Storage::makeDirectory($thumbnailPath, 0775, true, true);
            $thumbnailImage->resize(182, 268);
            $thumbnailImage->save(storage_path('app/'.$thumbnailPath.$filename));
        }

        $image = new Image();

        $image->main = 1;
        $image->filename = $filename;
        $image->extension = 'jpg';

        $me->image()->save($image);
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
