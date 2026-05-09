<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model
{
    public $timestamps = false;
    protected $table = 'delivery_methods';
    protected $primaryKey = 'delivery_method_id';
    protected $fillable = ['name'];
}
