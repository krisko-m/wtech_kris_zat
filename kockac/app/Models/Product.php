<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'name',
        'description',
        'price',
        'author',
        'recommended_age',
        'duration',
        'number_of_players',
        'stock_quantity',
        'complexity',
        'added',
    ];

    public function genres(){
        return $this->belongsToMany(Genre::class, 'genre_of_product', 'product_id', 'genre_id');
    }
}
