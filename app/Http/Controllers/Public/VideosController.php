<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Video;
use Intervention\Image\Facades\Image;
use Auth;
use File;
use Storage;
use App\Services\TorrentEncoder;
use App\Services\Torrent;

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


        if(Storage::exists($video->file_path . $video->file_hash . '.torrent')) {
            $torrent_file = File::get($video->file_path . $video->file_hash . '.torrent');

        } else {
            $torrent_file =  new Torrent($video->file_path.$video->file_name, 'udp://tracker.opentrackr.org:1337' );
            
            $torrent_file->name($video->file_name);
            $torrent_file->announce(array(
                'udp://tracker.leechers-paradise.org:6969',
                'udp://tracker.opentrackr.org:1337',
                'udp://tracker.coppersurfer.tk:6969',
                'udp://explodie.org:6969',
                'udp://tracker.empire-js.us:1337',
                'http://torrent.tracker/annonce', 
                'http://alternate-torrent.tracker/annonce',
                'udp://tracker.openbittorrent.com:80',
                'udp://tracker.internetwarriors.net:1337',
                'udp://exodus.desync.com:6969',
                'wss://tracker.btorrent.xyz',
                'wss://tracker.openwebtorrent.com',
                'wss://tracker.fastcast.nz',
            ));
        }

        $torrent = $bencoder->decode($torrent_file);
        $torrent = $bencoder->sanitize($torrent);
        $torrent['url-list'][0] = url('v/f/'.$video->id);

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

    public function imageFile($id, $iid) 
    {
        $video = Video::findOrFail($id);
        $image = Image::make(public_path($video->file_path . $video->file_hash . '_0' . $iid . '.png'));
        $image->fit(640, 360);

        return $image->response()->setExpires(carbon()->addDays(30))
            ->header('Cache-Control', 'public,max-age=' . (3600 * 24 * 30) . ',s-maxage=' . (3600 * 24 * 30));
    }

    public function videoFile($id) 
    {
        $video = Video::findOrFail($id);

        return response()->file($video->file_path . $video->file_name);
    }
}