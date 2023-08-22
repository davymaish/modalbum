<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\LiveTv;
use Illuminate\Http\Request;
use Auth;

class LiveTvController extends Controller
{

    /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        meta()->setMeta('My LiveTVs');

        $tvs = auth()->user()->livetvs;
        return view('user.livetvs.index', compact('tvs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $albums = auth()->user()->albums;
        return view('user.livetvs.create',compact('albums'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slider = new LiveTv();
        $slider->fill($request->all());

        if ($file = $request->file('featured_image')){
            $photo_name = str_random(3).$request->file('featured_image')->getClientOriginalName();
            $file->move('assets/images/tv',$photo_name);
            $slider['featured_image'] = $photo_name;
        }
        $slider->save();
        return redirect('my/livetvs')->with('message','New Tv Added Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $albums = auth()->user()->albums;
        $tv = LiveTv::where('created_by', Auth::id())->findOrFail($id);
        return view('user.livetvs.edit', compact('tv','albums'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slider = LiveTv::where('created_by', Auth::id())->findOrFail($id);
        $data = $request->all();

        if ($file = $request->file('featured_image')){
            $photo_name = str_random(3).$request->file('featured_image')->getClientOriginalName();
            $file->move('assets/images/tv',$photo_name);
            $data['featured_image'] = $photo_name;
        }
        if ($request->live !="yes"){
            $data['live'] = "no";
        }
        if ($request->featured !="yes"){
            $data['featured'] = "no";
        }

        $slider->update($data);
        return redirect('my/livetvs')->with('message','Tv Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tv = LiveTv::where('created_by', Auth::id())->findOrFail($id);
        $tv->delete();

        return redirect('my/livetvs')->with('message','TV/Video Deleted Successfully.');
    }
}
