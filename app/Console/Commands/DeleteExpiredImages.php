<?php

namespace App\Console\Commands;

use App\Jobs\DeleteImage;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Console\Command;

class DeleteExpiredImages extends Command
{

    protected $signature = 'imagez:delete:expired';

    protected $description = 'Delete expired images';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $albums = Album::with('images')->where('expire', '<', carbon())->get();
        if ($albums->count()) {
            foreach ($albums as $album) {
                if (!empty($album->images)) {
                    foreach ($album->images as $image) {
                        $this->info('Deleting - ' . $image->hash);
                        dispatch(new DeleteImage($image->id));
                    }
                }
                $album->delete();
            }
        }

        $images = Photo::whereNull('album_id')->where('expire', '<', carbon())->get();
        if ($images->count()) {
            foreach ($images as $image) {
                $this->info('Deleting - ' . $image->hash);
                dispatch(new DeleteImage($image->id));
            }
        }
    }
}
