<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;
    public function products()
    {
        return $this->hasMany(Product::class,'subcategory_id', 'id');
    }
    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
