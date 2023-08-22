<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use App\Models\Video;
use App\Models\LiveTV;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        meta()->setMeta('My Dashboard');

        $data = [
            'url'    => 'my',
            'albums' => auth()->user()->albums->count(),
            'images' => auth()->user()->photos()->whereNull('album_id')->count(),
            'videos' => auth()->user()->videos()->whereNull('album_id')->count(),
            'livetvs' => auth()->user()->livetvs()->whereNull('album_id')->count(),
        ];

        return view('user.dashboard', $data);
    }
}