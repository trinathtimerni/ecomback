<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function getSubCategory(){
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }

    public function child_category()
    {
        return $this->hasMany(ChildCategory::class, 'subcategory_id', 'id');
    }
     public function sub_category() {
        return $this->getSubCategory()->with('child_category');
    }

    public static function CategoryList()
    {
        return Category::orderby("id","desc")->get([
            'id',
            'name',
            'description',
            'slug',
            'image',
            'status'
        ]);
    }
}
