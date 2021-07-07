<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use App\Product;

class HomeController extends Controller
{
    public function getCarousel()
    {
        $images[0] = asset('asset/sliders/slider1.jpg'); 
        $images[1] = asset('asset/sliders/slider2.jpg'); 
        $images[2] = asset('asset/sliders/slider3.jpg'); 
        return response($images);
    }

    public static function getIp()
    {
        $ip = Request::ip();
        return response()->json($ip);
    }
    public static function getRandom(Request $request,$pid)
    {
        $products = Product::select('image','name','price','product_id')->where('product_id','!=',$pid)->inRandomOrder()->limit(3)->get();
        if($products)
        {
            return response()->json($products);
        }
        else
        {
            return "No Products";
        }
    }
}
