<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;
    protected $table = 'order_items';
    protected $primaryKey = 'order_item_id';
    protected $fillable = ['product_id', 'order_id', 'quantity', 'price_at_purchase'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
