<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Category;
use App\CategoryProduct;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }

    public function addCategory(Request $request)
    {

        $valid = $request->validate([
            'name' =>'required|regex:/^[\pL\s\-]+$/u|min:4|max:12|unique:categories,name',
            'details'=>'required|min:4|max:50',
        ]);

        if($this->guard()->user()->name =='admin')
        {
            $lastCatId = Category::orderby('category_id','desc')->first();

            if($lastCatId)
            {
                $lastCatId = $lastCatId->category_id;
                $lastCatId = intval(substr($lastCatId,2,6));
                $lastCatId++;
                $lastCatId = 'CT'.$lastCatId;
            }
            else
            {
                $lastCatId = 'CT10000';
            }

            $newCat = new Category;
            $newCat->category_id = $lastCatId;
            $newCat->name= $request->name;
            $newCat->details = $request->details;
            $newCat->user_id = $this->guard()->user()->user_id;
            if($newCat->save())
            {

                return response('Success');
            }
            else
            {
                return respose('failed');
            }



        }
        else
        {
            return response("Invalid Access");
        }
    }


    public function getCategory()
    {
        $categories = Category::select('category_id','name','details')->orderBy('created_at','desc')->paginate(4);
        return response()->json($categories);    
    }

    public function deleteCategory(Request $request,$id)
    {
        if($this->guard()->user()->name =='admin')
        {
            $category = Category::where('category_id',$id)->first();
            if($category)
            {
                $relationDelete = CategoryProduct::where('category_id',$category->category_id)->delete();
                if($category->delete())
                {
                    return response('success');
                }
                else
                {
                    return respose('failed');
                }

            }
            else
            {
                return response(['Invalid Access']);
            }
        }
        else
        {
            return response(['Invalid Access'],401);
        }
    }

    public function editCategory(Request $request,$id)
    {
        if($this->guard()->user()->name =='admin')
        {
            $category = Category::where('category_id',$id)->first();
            if($category)
            {
                return response()->json($category);
            }
            else
            {
                return response("failed");
            }
        }
        else
        {
            return response(['Invalid Access'],401);
        }
    }
    
    public function editCategoryVerify(Request $request,$id)
    {
        if($this->guard()->user()->name =='admin')
        {
            $valid = $request->validate([
                'name' =>'required|regex:/^[\pL\s\-]+$/u|min:4|max:12',
                'details'=>'required|min:4|max:50',
            ]);

            //Editing Name Check
            $nameCheck = Category::where('category_id','!=',$id)->get();
            
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
            //------------
            

            $category = Category::where('category_id',$id)->first();



            if($category)
            {
                $category->name = $request->name;
                $category->details = $request->details;
                if($category->save())
                {
                    return response('Success');
                }
            }
            else
            {
                return response("failed");
            }
        }
        else
        {
            return response(['Invalid Access'],401);
        }
    }

    //guard func

    public function guard()
    {
        return Auth::guard();
    }
}
