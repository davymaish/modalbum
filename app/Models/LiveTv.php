<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveTv extends Model
{
    protected $table = "livetvs";

    protected $fillable = [
        'title',
        'album_id', 
        'featured_image', 
        'embed', 
        'live', 
        'description', 
        'featured', 
        'views', 
        'status'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }
}
