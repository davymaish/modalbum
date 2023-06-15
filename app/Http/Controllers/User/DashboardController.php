<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use App\Models\Video;
use App\Models\LiveTV;
use App\Services\Filer;
use App\Services\Imager;
use Auth;

class DashboardController extends Controller
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

    public function index()
    {
        meta()->setMeta('My Dashboard');

        $data = [
            'url'    => 'my',
            'albums' => Album::where('created_by', Auth::id())->count(),
            'images' => Photo::where('created_by', Auth::id())->whereNull('album_id')->count(),
            'videos' => Video::where('created_by', Auth::id())->whereNull('album_id')->count(),
            'livetvs' => LiveTv::where('created_by', Auth::id())->whereNull('album_id')->count(),
        ];

        return view('user.index', $data);
    }

    public function albums()
    {
        meta()->setMeta('My Albums');

        $data = [
            'url'    => 'my',
            'albums' => Album::with(['images'])->where('created_by', Auth::id())->latest()->paginate(20),
        ];

        return view('user.albums', $data);
    }

    public function images()
    {
        meta()->setMeta('My Images');

        $data = [
            'url'    => 'my',
            'images' => Photo::where('created_by', Auth::id())->whereNull('album_id')->latest()->paginate(48),
        ];

        return view('user.images', $data);
    }

    public function videos()
    {
        meta()->setMeta('My Videos');

        $data['videos'] = Video::where('published', 1)->where('created_by', Auth::id())->whereNull('album_id')->latest()->paginate(48);

        return view('user.videos', $data);
    }
}