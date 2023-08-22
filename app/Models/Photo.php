<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';

    protected $fillable = [
        'album_id',
        'hash',
        'file_hash',
        'title',
        'description',
        'image_extension',
        'image_width',
        'image_height',
        'adult',
        'private',
        'expire',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }
}
