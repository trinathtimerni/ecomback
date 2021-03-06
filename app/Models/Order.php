<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    public function order_details()
    {
        return $this->hasMany(OrderDetails::class,"order_id","id");
    }
    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");
    }
}
