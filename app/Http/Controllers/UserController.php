<?php

namespace App\Http\Controllers;

use App\User;
use App\Category;
use App\Todo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    //gaurd func

    public function guard()
    {
        return Auth::guard();
    }
}
