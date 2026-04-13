<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $primaryKey = 'genre_id';
    protected $table = 'genre';
    public $timestamps = false;

    protected $fillable = [
        'genre_type'
    ];
}
