<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'cart_id';
    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'session_token',
        'created_at',
    ];

    public function items(){
        return $this->hasMany(CartItem::class, 'cart_id', 'cart_id');
    }
}
