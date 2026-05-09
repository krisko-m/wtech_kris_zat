<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    public $timestamps = false;
    protected $table = 'order_statuses';
    protected $primaryKey = 'order_status_id';
    protected $fillable = ['status'];
}
