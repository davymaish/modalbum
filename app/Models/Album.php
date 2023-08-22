<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';

    protected $fillable = [
        'hash',
        'title',
        'description',
        'adult',
        'private',
        'expire',
        'created_by'
    ];

    public function images()
    {
        return $this->hasMany(Photo::class, 'album_id', 'id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'album_id', 'id');
    }

    public function livetvs()
    {
        return $this->hasMany(LiveTv::class, 'album_id', 'id');
    }
}
