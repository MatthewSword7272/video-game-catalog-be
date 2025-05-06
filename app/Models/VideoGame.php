<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoGame extends Model
{
    protected $table = 'v_games';

    protected $fillable = [
        'title',
        'genre',
        'developer',
        'publisher',
        'release_year',
        'platform',
        'region_code',
        'image',
        'user_id',
        'description',
    ];
}
