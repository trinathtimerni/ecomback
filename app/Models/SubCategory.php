<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function child_category()
    {
        return $this->hasMany(ChildCategory::class, 'subcategory_id', 'id');
    }
    
    public static function SubcategoryList()
    {
        return SubCategory::orderby("id","desc")->get([
            'id',
            'category_id',
            'name',
            'status'
        ]);
    }

    public function sub_category()
    {
        return $this->hasMany(ChildCategory::class, 'subcategory_id', 'id');
    }
}
