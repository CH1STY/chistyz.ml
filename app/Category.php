<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    
    public function products()
    {
        return $this->belongsToMany(Product::class,'category_product','category_id','product_id','category_id','product_id');
    }
}
