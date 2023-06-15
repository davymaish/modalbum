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
        'image_title',
        'image_description',
        'image_extension',
        'image_width',
        'image_height',
        'adult',
        'private',
        'expire',
        'created_by'
    ];
}
