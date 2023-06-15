<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\LiveTv;
use Illuminate\Http\Request;

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

        $tvs = LiveTv::all();
        return view('user.livetvs', compact('tvs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Album::all();
        return view('user.livetv-add',compact('categories'));
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
        return redirect('admin/tv')->with('message','New Tv Added Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Album::all();
        $tv = LiveTv::findOrFail($id);
        return view('user.livetv-edit', compact('tv','categories'));
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
        $slider = LiveTv::findOrFail($id);
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
        return redirect('admin/tv')->with('message','Tv Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tv = LiveTv::findOrFail($id);
        $tv->delete();

        return redirect('admin/tv')->with('message','TV/Video Deleted Successfully.');
    }
}
