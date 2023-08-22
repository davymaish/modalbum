<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteImage;
use App\Models\Album;
use App\Models\Photo;
use App\Services\Filer;
use App\Services\Imager;
use App\Traits\AlbumActions;
use Auth;
use File;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    use AlbumActions;

    public function index()
    {
        meta()->setMeta('My Albums');

        $data = [
            'url'    => 'my',
            'albums' => auth()->user()->albums()->with(['images'])->latest()->paginate(20),
        ];

        return view('user.albums.index', $data);
    }

    public function create()
    {
        meta()->setMeta('New Album');
        return view('user.albums.create');
    }
    
    public function store()
    {
        $album = $this->createNewAlbum(request()->all());
        
        flash('Album Added Successfully.', 'success');

        return redirect('my/albums');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $album = Album::where('created_by', Auth::id())->findOrFail($id);
        $expire = 0;

        if (!empty($album->expire) && $album->expire > carbon()->now()) {
            $subminutes = carbon()->parse($album->expire)->diffInMinutes(carbon()->now());

            if ($subminutes <= 0) {$expire = 0;}
            elseif ($subminutes <= 10) {$expire = 10;}
            elseif ($subminutes <= 60) {$expire = 60;}
            elseif ($subminutes <= 1440) {$expire = 1440;}
            elseif ($subminutes <= 10080 ) {$expire = 10080;}
            else {$expire = 43800;}
        }

        return view('user.albums.edit', compact('album','expire'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $album = Album::where('created_by', Auth::id())->findOrFail($id);

        $data = request()->all();
        $expire = (request()->get('expire') >= 43800) ? 43800 : request()->get('expire');
        
        $data['expire'] = !empty($expire) ? carbon()->addMinutes($expire) : null;
        $data['adult'] = !empty(request()->get('adult')) ? 1 : 0;
        $data['private'] = !empty(request()->get('private')) ? 1 : 0;
        $album->update($data);
        
        flash('Album Updated Successfully.', 'success');

        return redirect('my/albums');
    }

    public function ajaxDelete()
    {
        $id = (int)request()->get('id');
        if (empty($id)) {
            return response()->json('Invalid ID!', 422);
        }

        $album = auth()->user()->albums()->findOrFail($id);

        $data = $this->deleteAlbum($album);

        return response()->json($data['message'], $data['success']? 200 : 422);
    }
}