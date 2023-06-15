<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveTv extends Model
{
    protected $table = "livetvs";
    protected $fillable = ['title','category', 'featured_image', 'embed', 'live', 'description', 'featured', 'views', 'status'];
    public $timestamps = false;
}
