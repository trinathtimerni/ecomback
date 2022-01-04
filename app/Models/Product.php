<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
