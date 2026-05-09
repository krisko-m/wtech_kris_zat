<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    public $timestamps = false;
    protected $table = 'order_addresses';
    protected $primaryKey = 'order_address_id';
    protected $fillable = ['first_name', 'last_name', 'email', 'address', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }
}
