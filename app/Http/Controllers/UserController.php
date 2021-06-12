<?php

namespace App\Http\Controllers;

use App\User;
use App\UserDetails;
use App\Category;
use App\Todo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Image;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('JWT');
    }

    public function addTodo(Request $request)
    {
        if($this->guard()->user() != null)
        {
            $valid = $request->validate([
                'title' => 'required|alpha|max:15|min:3',
                'details'=> 'required|max:50|min:3',
                'date'=> 'required|date|after: 1 hour'

            ]);
            
            $lastTodoId = Todo::orderby('todo_id','desc')->first();

            if($lastTodoId)
            {
                $lastTodoId = $lastTodoId->todo_id;
                $lastTodoId = intval(substr($lastTodoId,2,6));
                $lastTodoId++;
                $lastTodoId = 'TD'.$lastTodoId;
            }
            else
            {
                $lastTodoId = 'TD10000';
            }

            $newTodo = new Todo;
            $newTodo->header = $request->title;
            $newTodo->todo_id = $lastTodoId;
            $newTodo->details = $request->details;
            $newTodo->todo_date = $request->date;
            $newTodo->user_id = $this->guard()->user()->user_id;

            if($newTodo->save())
            {
                return response('Success');
            }
            else
            {
                return reponse('failed');
            }
        }
        else
        {
            return response('failed',401);
        }
    }
    public function getTodo(Request $request)
    {
        if($this->guard()->user() != null)
        {
            $todo = Todo::where('user_id',$this->guard()->user()->user_id)->orderBy('created_at','desc')->get();
            return response()->json($todo);
        }
        else
        {
            return response('failed',401);
        }
    }

    public function deleteTodo(Request $request,$id)
    {
        if($this->guard()->user() != null)
        {
            $todo = Todo::where('user_id',$this->guard()->user()->user_id)->where('id',$id)->first();
            if($todo)
            {
                $todo->delete();
                return response('Success');
            }
            else
            {
                return response('failed',401);
            }
        }
        else
        {
            return response('failed',401);
        }
    }

    public function fetchCat()
    {
        $categories = Category::select('name','category_id')->get();
        return response()->json($categories);
    }

    public function getUserId()
    {
        $userId = $this->guard()->user()->only('user_id');
        return response()->json($userId);
    }

    public function getUserDetails()
    {   
        $userDetails =  User::with('userdetails')->where('user_id',$this->guard()->user()->user_id)->first();
        return response()->json($userDetails);
    }


    public function updateProfile(Request $request)
    {
        $validat = $request->validate([
            'fullname' => 'required|regex:/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/|max:50|min:4',
            'phone' => 'nullable|regex:/(01)[0-9]{9}/',
            'website' =>'nullable|min:6|max:30',
            'twitter' =>'nullable|min:6|max:30',
            'github' =>'nullable|min:6|max:30',
            'instagram' =>'nullable|min:6|max:30',
            'facebook' =>'nullable|min:6|max:30',
            
        ],
        $messages=[
            'phone.regex' => 'Phone number should be 11 Character Example: 01711111111'
        ]);

        $userDetails = UserDetails::where('user_id',$this->guard()->user()->user_id)->first();
        $userDetails->fullname = $request->fullname;
        $userDetails->phone = $request->phone;
        $userDetails->website = $request->website;
        $userDetails->github = $request->github;
        $userDetails->twitter = $request->twitter;
        $userDetails->instagram = $request->instagram;
        $userDetails->facebook = $request->facebook;
        if($userDetails->save())
        {
            return response('Success');
        }
        else
        {
            
            return response('failed');
        }
    }

    public function updateProfilePic(Request $request)
    {

        $imageValidator  = $request->validate([
            'image' => 'mimes:jpg,jpeg,png,bmp,tiff|max:5120',
        ],
        $messages = [
            'image.max'   => 'Image should be less than 5 MB'
        ]);

        $userDetails = UserDetails::where('user_id',$this->guard()->user()->user_id)->first();
         //Inserting Image
    
            $imageName = time().$userDetails->user_id.".".$request->image->getClientOriginalExtension();
            $path = 'asset/user_image/';
 
         //Resized Image
 
            $product_photo = \public_path($path.$imageName);
 
            $resized_image = Image::make($request->image);
            $resized_image->resize(350,350);
            $resized_image->save(\public_path($path.$imageName));
         //
         if($userDetails->image!='dummy.png')
         {
             $unlinkName = substr($userDetails->image,1);
             unlink($unlinkName);
         }
        $userDetails->image = '/'.$path.$imageName;
        if($userDetails->save())
        {
            return response("Success");
        }
        else
        {
            return response("Success");

        }

    }

    //guard func

    public function guard()
    {
        return Auth::guard();
    }
}
