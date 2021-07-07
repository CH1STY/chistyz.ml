<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class CartController extends Controller
{
    public function getCartItem(Request $request)
    {
       $products = \json_decode($request->cartArray);
       
       $data = array();
       foreach($products as $key=>$value)
       {
           $product_one = Product::where('product_id',$key)->first();

           if(!$product_one || !is_numeric($value))
           {
                return response("Fatal Error");  
           }
           else
           {
               array_push($data,[$product_one->name,$product_one->price,$value,$key]);
           }
           
       }
       return response($data);
       
    }
}
