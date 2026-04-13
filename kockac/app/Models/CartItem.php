<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'cart_item_id';
    protected $table = 'cart_items';

    protected $fillable = [
        'product_id',
        'cart_id',
        'quantity',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function cart(){
        return $this->belongsTo(Cart::class, 'cart_id', 'cart_id');
    }
}
