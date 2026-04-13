<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $primaryKey = 'genre_id';

    protected $fillable = [
        'genre_type'
    ];
}
