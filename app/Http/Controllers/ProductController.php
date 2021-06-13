<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Category;
use App\CategoryProduct;
use Image;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['index','show','getCat',]]);
    }

    public function fetchCat()
    {
        $categories = Category::select('name','category_id')->get();
        echo "Hello World";
        return response()->json($categories);
    }


    public function index(Request $request)
    {
        if($request->ppp)
        {
            if(intval($productPerPage = $request->ppp))
            {

            }
            else
            {

                $productPerPage = 5;
            }
            

        }
        else
        {
            $productPerPage = 5;
        }
        $searchText = $request->search;
        $product = Product::with('categories')
                            ->where('product_id', 'LIKE', '%'.$request->search.'%')
                            ->orWhere('name', 'LIKE', '%'.$request->search.'%')
                            ->orWhere('price', 'LIKE', '%'.$request->search.'%')
                            ->orWhere('details', 'LIKE', '%'.$request->search.'%')
                            ->orWhereHas('categories', function ($query) use($searchText) {
                                $query->where('name', 'LIKE', '%'.$searchText.'%');
                            })                            
                            ->orderBy('created_at','desc')
                            ->paginate($productPerPage);
        return response()->json($product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->guard()->user()->name =='admin')
        {

            $valid = $request->validate([
                'name' => 'required|min:4|max:10|regex:/^[\pL\s\-]+$/u|unique:products,name',
                'details' =>'required|min:10|max:500',
                'price' => 'required|numeric|min:0|max:99999999',
                'stock' => 'required|numeric|min:0|max:9999',
                'categories' => 'required|array|between:1,3',
                'categories.*' => 'exists:categories,category_id',
                'image' => 'required|mimes:jpg,jpeg,png,bmp,tiff|max:5120'
            ],
            $messages = [
                'image.max'   => 'Image should be less than 5 MB'
            ]);
    
            $nextProductId = Product::orderBy('product_id','desc')->first();
            if($nextProductId)
            {
                $nextProductId = $nextProductId->product_id;
                $nextProductId = intval(substr($nextProductId,1,6));
                $nextProductId++;
                $nextProductId = 'P'.$nextProductId;
            }
            else
            {
                $nextProductId = 'P100000';
            }
    
            //Inserting Image
    
            $imageName = time().$nextProductId.".".$request->image->getClientOriginalExtension();
            $path = 'asset/products';
    
            //Resized Image
    
            $product_photo = \public_path($path.$imageName);
    
            $resized_image = Image::make($request->image);
            $resized_image->resize(200,200);
            $resized_image->save(\public_path($path.'/v200x200'.$imageName));
            $resized_image->resize(40,40);
            $resized_image->save(\public_path($path.'/v40x40'.$imageName));
    
    
            //----
            $request->image->move(\public_path($path),$imageName);
    
    
    
    
            //
    
            $newProduct = new Product;
            $newProduct->product_id = $nextProductId;
            $newProduct->name = $request->name;
            $newProduct->details = $request->details;
            $newProduct->price = $request->price;
            $newProduct->stock = $request->stock;
            $newProduct->categories()->attach($request->categories,['product_id'=>$newProduct->product_id]);
            $newProduct->status = "coming_soon";
            $newProduct->image = $imageName;
    
            if($newProduct->save())
            {
                return response('Success');
            }
            else
            {
                return response('failed');
            }
        }
        else
        {
            return response('failed');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($this->guard()->user()->name =='admin')
        {
            $product = Product::with('categories')->where('product_id',$id)->first();
            return response()->json($product);
        }
        else
        {
            return response('Invalid Access');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($this->guard()->user()->name =='admin')
        {
            $valid = $request->validate([
                'name' => 'required|min:4|max:15|regex:/^[\pL\s\-]+$/u',
                'details' =>'required|min:10|max:500',
                'price' => 'required|numeric|min:0|max:99999999',
                'stock' => 'required|numeric|min:0|max:9999',
                'categories' => 'required|array|between:1,3',
                'categories.*' => 'exists:categories,category_id',
                'status' => 'required|in:coming_soon,available,out of stock,pre-order',
            ]);
            $isImage =false;
            if($request->image)
            {
                $imageValidator  = $request->validate([
                    'image' => 'mimes:jpg,jpeg,png,bmp,tiff|max:5120',
                ],
                $messages = [
                    'image.max'   => 'Image should be less than 5 MB'
                ]);

                $isImage = true;
            }

            //Name Check
            $nameCheck = Product::where('product_id','!=',$id)->get();
            foreach($nameCheck as $value)
            {
                if($value->name==$request->name)
                {
                    $arr =[
                            "message" => "The given data was invalid.", 
                            "errors" => [
                                "name" => [
                                    "The name has already been taken." 
                                ]
                            ]
                    ];
                    return response()->json($arr);
                }
            }
            //

            //Get Product Row

            $product = Product::where('product_id',$id)->first();

            if($product)
            {
                //image check
                if($isImage)
                {
                    //Previous Image deletion
                    unlink('asset/products/'.$product->image);
                    unlink('asset/products/v40x40'.$product->image);
                    unlink('asset/products/v200x200'.$product->image);
                    //----

                    //new Image Upload
                    //Inserting Image
                        
                    $imageName = time().$product->product_id.".".$request->image->getClientOriginalExtension();
                    $path = 'asset/products';

                    //Resized Image

                    $product_photo = \public_path($path.$imageName);

                    $resized_image = Image::make($request->image);
                    $resized_image->resize(200,200);
                    $resized_image->save(\public_path($path.'/v200x200'.$imageName));
                    $resized_image->resize(40,40);
                    $resized_image->save(\public_path($path.'/v40x40'.$imageName));


                    //----End of Resizing Upload
                    $request->image->move(\public_path($path),$imageName);

                    $product->image = $imageName;

                    //End of Image manipulation                    
                
                }

                //Deleting Previous Categories
                    $pivot = CategoryProduct::where('product_id',$id)->delete();
                //

                //Updating to New Categories
                    $product->categories()->attach($request->categories,['product_id'=>$product->product_id]);
                //

                //Updating Attributes
                    $product->name = $request->name;
                    $product->details = $request->details;
                    $product->price = $request->price;
                    $product->stock = $request->stock;
                    $product->status = $request->status;

                //

                //Saving

                if($product->save())
                {

                    return response("Success");
                }
                else
                {

                    return response("Failed");
                }

            }
            else
            {
                return response("Invalid Access");
            }



        }
        else
        {
            return response("Invalid Access");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->guard()->user()->name =='admin')
        {
            $product = Product::where('product_id',$id)->first();
            
            if($product)
            {
                unlink('asset/products/'.$product->image);
                unlink('asset/products/v40x40'.$product->image);
                unlink('asset/products/v200x200'.$product->image);
                $pivot = CategoryProduct::where('product_id',$id)->delete();
                $product->delete();
                return response('deleted');

            }
            else
            {

                return response('failed');
            }

            

        }
        return response('failed');
    }

    //guard func

    public function guard()
    {
        return Auth::guard();
    }
}
