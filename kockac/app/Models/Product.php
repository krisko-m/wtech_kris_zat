<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'name', 'author', 'publisher',
        'price', 'stock_quantity',
        'recommended_age',
        'duration_min', 'duration_max',
        'players_min', 'players_max',
        'complexity',
        'description', 'gameplay', 'contents',
    ];

    public function genres(){
        return $this->belongsToMany(Genre::class, 'genre_of_product', 'product_id', 'genre_id');
    }

    public function images(){
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }

    public function mainImage(){
        return $this->hasOne(ProductImage::class, 'product_id', 'product_id')->where('is_main', true);
    }
}
