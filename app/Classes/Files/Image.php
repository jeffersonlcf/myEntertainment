<?php

namespace App\Classes\Files;

use Image as ImageIntervention;
use App\Models\Image as ImageModel;
use App\Models\Me;
use Illuminate\Support\Facades\Storage;

class Image
{
    public $me;
    public $filename;
    private $thumbnailImage;
    public $thumbnailPath;
    public $originalPath;

    public function __construct(Me $me, $path) {
        $this->me = $me;
        $this->thumbnailImage = ImageIntervention::make($path);
        $this->filename = basename($path);
        $this->thumbnailPath = 'public/files/thumbnail/'.$this->me->id.'/';
        $this->originalPath = 'public/files/images/'.$this->me->id.'/';
    }

    public function store(){
        
        $this->save_images();

        $image = new ImageModel();

        $image->main = 1;
        $image->filename = $this->filename;
        $image->extension = $this->thumbnailImage->extension;

        $this->me->images()->save($image);
    }

    private function save_images()
    {
        if (!Storage::exists($this->originalPath)) {
            Storage::makeDirectory($this->originalPath, 0775, true, true);
            $this->thumbnailImage->save(Storage::disk('local')->path($this->originalPath.$this->filename));
        }

        if (!Storage::exists($this->thumbnailPath)) {
            Storage::makeDirectory($this->thumbnailPath, 0775, true, true);
            $this->thumbnailImage->resize(182, 268);
            $this->thumbnailImage->save(Storage::disk('local')->path($this->thumbnailPath.$this->filename));
        }
    }

}