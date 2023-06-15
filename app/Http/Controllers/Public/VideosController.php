<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Video;
use Intervention\Image\Facades\Image;
use Auth;
use App\Services\TorrentEncoder;

class VideosController extends Controller
{
    public function video($id)
    {
        $video = Video::findOrFail($id);
        meta()->setMeta($video->title);

        return view('public.videos.player', compact('video'));
    }

    public function torrent($id)
    {
        $video = Video::findOrFail($id);
        $bencoder = new TorrentEncoder();

        $torrent_file = $video->file_path . $video->file_hash . '.torrent';
        $torrent = $bencoder->decode(File::get($torrent_file));
        $torrent = $bencoder->sanitize($torrent);
        $torrent['url-list'][0] = url($video->file_path . $video->file_name);

        $content = $bencoder->encode($torrent);

        $headers = [
            'Content-Type'              => 'application/x-bittorrent',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Length'            => strlen($content),
            'Accept-Ranges'             => 'bytes',
            'Content-Disposition'       => 'attachment; filename="' . $video->file_hash . '.torrent' . '"',
            'Cache-Control'             => 'private, max-age=0, no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            'Pragma'                    => 'no-cache',
        ];

        return response($content, 200, $headers)
            ->setLastModified(carbon())
            ->setExpires(carbon()->subYears(10));
    }

    public function image($id, $iid) 
    {
        $video = Video::findOrFail($id);
        $image = Image::make(public_path($video->file_path . $video->file_hash . '_0' . $iid . '.png'));
        $image->fit(640, 360);

        return $image->response()->setExpires(carbon()->addDays(30))
            ->header('Cache-Control', 'public,max-age=' . (3600 * 24 * 30) . ',s-maxage=' . (3600 * 24 * 30));
    }
}