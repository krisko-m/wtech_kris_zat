<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    public $timestamps = false;
    protected $table = 'payment_methods';
    protected $primaryKey = 'payment_method_id';
    protected $fillable = ['name'];
}
