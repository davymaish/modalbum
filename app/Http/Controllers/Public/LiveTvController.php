<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\LiveTv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LiveTvController extends Controller
{
    public function tv($id)
    {
        $tvinfo = LiveTv::findOrFail($id);
        $tvinfo->increment('views');
        meta()->setMeta($tvinfo->title);

        return view('public.livetv.tvpage',compact('tvinfo'));
    }
}
