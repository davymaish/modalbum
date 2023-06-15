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
        $views['views'] = $tvinfo->views + 1;
        $tvinfo->update($views);
        return view('tvpage',compact('tvinfo'));
    }
}
