<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use App\Models\Video;
use App\Models\LiveTv;

class AlbumController extends Controller
{
    public function album($hash)
    {
        $album = Album::where('hash', $hash)->with(['images','videos','livetvs'])->firstOrFail();
        $images = Photo::where('album_id', $album->id)->paginate(20);
        $videos = Video::where('album_id', $album->id)->paginate(20);
        $livetvs = LiveTv::where('album_id', $album->id)->paginate(20);
        meta()->setMeta(($album->title ? $album->title : 'Album ' . $album->hash));

        return view('public.album.album', compact('album', 'images', 'videos', 'livetvs'));
    }
}
