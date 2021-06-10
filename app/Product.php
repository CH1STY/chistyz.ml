<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_product','product_id','category_id','product_id','category_id')->select(array('categories.category_id','categories.name'));
    }
}
