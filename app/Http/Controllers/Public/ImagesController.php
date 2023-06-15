<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use App\Services\Filer;
use App\Services\Imager;

class ImagesController extends Controller
{
    /**
     * @var Filer
     */
    private $filer;

    /**
     * @var Imager
     */
    private $imager;

    public function __construct()
    {
        $this->filer = app(Filer::class);
        $this->imager = app(Imager::class);
    }

    public function album($hash)
    {
        $album = Album::where('hash', $hash)->with(['images'])->firstOrFail();
        $images = Photo::where('album_id', $album->id)->paginate(20);
        meta()->setMeta(($album->album_title ? $album->album_title : 'Album ' . $album->hash));

        return view('public.images.album', compact('album', 'images'));
    }

    public function image($hash)
    {
        $extension = str_contains($hash, '.');
        if ($extension) {
            return $this->imageFile($hash);
        }

        $image = Photo::where('hash', $hash)->firstOrFail();
        meta()->setMeta(($image->image_title ? $image->image_title : 'Image ' . $image->hash));

        return view('public.images.image', compact('image'));
    }

    public function thumbnail($hash)
    {
        if ($hash) {
            return $this->imageFile($hash, true);
        }

        abort(404, 'Image Not Found!');
    }

    private function imageFile($filename, $thumb = false)
    {
        $hash = explode('.', $filename)[0];
        $image = Photo::where('hash', $hash)->firstOrFail();

        $file_content = $this->filer->type('images')->get($filename);
        if (empty($file_content)) {
            abort(404, 'Image Not Found');
        }

        $image_file = $this->imager->setImage($file_content);

        $response = response($file_content);
        if ($thumb) {
            $image_file->fit(300, 170);
            $response = response($image_file->image->encode());
        }

        $headers = [
            'Content-Type'  => extension_to_mime($image->image_extension),
        ];

        if ($image->private) {
            $headers['X-Robots-Tag'] = 'noindex, noarchive';
        }

        if ($image->expire) {
            $headers['Cache-Control'] = 'public,max-age=' . (carbon($image->expire)->diffInSeconds()) . ',s-maxage=' . (carbon($image->expire)->diffInSeconds());
            $response->setExpires(carbon($image->expire));
        } else {
            $headers['Cache-Control'] = 'public,max-age=' . (3600 * 24 * 30) . ',s-maxage=' . (3600 * 24 * 30);
            $response->setExpires(carbon()->addDays(30));
        }

        return $response->withHeaders($headers);
    }
}
