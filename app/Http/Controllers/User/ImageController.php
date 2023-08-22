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

class ImageController extends Controller
{
    use AlbumActions;

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
        meta()->setMeta('My Images');

        $data = [
            'url'    => 'my',
            'images' => auth()->user()->photos()->whereNull('album_id')->latest()->paginate(48),
        ];

        return view('user.images.index', $data);
    }

    public function upload()
    {
        meta()->setMeta('ImageZ', 'ImageZ - Free and Secure Image Hosting & Photo Sharing');

        $albums = auth()->user()->albums;

        return view('user.images.upload',compact('albums'));
    }
    
    public function create()
    {
        if ($images = request()->get('images')) {
            $expire = (request()->get('expire') >= 43800) ? 43800 : request()->get('expire');
            $album_id = null;

            if (request()->get('album')) {
                $album = auth()->user()->albums()->findOrFail(request()->get('album'));
                $album_id = $album->id;
            }

            if (count($images) > 1) {
                if (!$album_id) {
                    $album = $this->createNewAlbum(request()->all());
                }

                Photo::whereIn('id', $images)->update([
                    'album_id' => $album->id,
                    'adult'    => !empty(request()->get('adult')) ? 1 : 0,
                    'private'  => !empty(request()->get('private')) ? 1 : 0,
                ]);

                return redirect('a/' . $album->hash);
            }

            $image = Photo::find($images['0']);
            $image->title = !empty(request()->get('title')) ? request()->get('title') : null;
            $image->album_id = $album_id;
            $image->description = !empty(request()->get('description')) ? request()->get('description') : null;
            $image->adult = !empty(request()->get('adult')) ? 1 : 0;
            $image->private = !empty(request()->get('private')) ? 1 : 0;
            $image->expire = !empty($expire) ? carbon()->addMinutes($expire) : null;

            $image->save();

            return redirect('i/' . $image->hash);
        }

        return redirect()->back();
    }

    public function ajaxUpload()
    {
        $output = [];

        $image_file = request()->file('qqfile');

        if ($image_file->getSize() > computer_size(64, 'mb')) {
            $output['preventRetry'] = true;
            $output['error'] = 'File size exceeds 64mb';

            return response()->json($output);
        }

        $file_hash = sha1_file($image_file->getRealPath());

// TODO: Find a better way to handle duplicate uploads
//        if (!Auth::check()) {
//            $dupe_image = Photo::where('file_hash', $file_hash)->where('created_by', 1)->first();
//            if ($dupe_image) {
//                $output['success'] = true;
//                $output['imageId'] = $dupe_image->id;
//
//                return response()->json($output, 200);
//            }
//        }

        $extension = mime_to_extension($image_file->getMimeType());
        if (!in_array($extension, ['jpg', 'gif', 'png'])) {
            $output['preventRetry'] = true;
            $output['error'] = 'invalid extension. Allowed: jpg, gif, png.';

            return response()->json($output);
        }

        try {
            $image = $this->imager->setImage($image_file);
        } catch (\Exception $e) {
            $output['preventRetry'] = true;
            $output['error'] = 'Failed to process image';

            return response()->json($output);
        }

        $hash = $this->generateHash(8);
        while (Photo::where('hash', $hash)->first()) {
            $hash = $this->generateHash(8);
        }

        $this->filer->type('images')->put($hash . '.' . $extension, File::get($image_file->getRealPath()));

        $imagedb = Photo::create([ 
            'hash'            => $hash, 
            'file_hash'       => $file_hash, 
            'title'     => $this->guessImageTitle($image_file->getClientOriginalName()), 
            'image_extension' => $extension, 
            'image_width'     => $image->getInfo()['width'], 
            'image_height'    => $image->getInfo()['height'], 
            'created_by'      => (Auth::check()) ? Auth::id() : 1,
        ]);

        $output['success'] = true;
        $output['imageId'] = $imagedb->id;

        return response()->json($output, 200);
    }

    public function ajaxDelete()
    {
        $id = (int)request()->get('id');
        if (empty($id)) {
            return response()->json('Invalid ID!', 422);
        }

        $image = Photo::findOrFail($id);
        if ($image->created_by == Auth::id() || Auth::id() == 2) {
            $this->dispatch(new DeleteImage($image->id));
            $image->delete();

            return response()->json('Image Deleted Successfully!', 200);
        }

        return response()->json('System Error!', 422);
    }

    private function guessImageTitle($name)
    {
        $filename = pathinfo($name, PATHINFO_FILENAME);
        $filename = str_replace('_', '-', $filename);

        return title_case(str_slug($filename, ' '));
    }
}