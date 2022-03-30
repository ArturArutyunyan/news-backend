<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Http; 

class UserController extends Controller
{
    public $successStatus = 200;

    public function register(Request $request) {
        if (User::where('email', $request->email)->exists()) {
            return response()->json(['error'=>'This email already exists!', 400]);
         }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $errors = $validator->errors();
        if($errors->any()){
            return response()->json($errors, 400);
        }
               
        $user = new User;
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->password=Hash::make($request->input('password'));
        $user->avatar=$request->input('avatar');
        $user->save();
        return response()->json($user);
    }

    public function login(Request $request) {
        $validator = $request->validate([
            'email' => 'required',
            'password' => 'required|min:6'
        ]);
        if(!Auth::attempt($validator)){
            return response()->json(['error' => 'Incorrect email or password', 400]);
        }
       
        $user = Auth::user();
        $token = $user->createToken('login')->accessToken;
            return response()->json(['token'=>$token, 'user'=>$user, 200]);
    }

    public function getUser(Request $request) {
        $user_id = $request->user()->id;
        $user = User::find($user_id);
        $user_posts = $user->posts()->get();
            return response()->json(['user'=>$user, 'user_posts'=>$user_posts, 200]);
    }

    public function getOtherUser(Request $request, $id) {
        $user = User::find($id);

        if (!$user) {
            return response()->json('There is not such user!');
        }

        return response()->json(['user' => $user, 'user_posts' => $user->posts, 200]);
    }

    public function updateUser(Request $request) {
        $user_id = $request->user()->id;
        $user = User::find($user_id);
        
        if($request->name ) {
            $user->name = $request->name;
        };

        if($request->hasFile('avatar')) {
            $destination_path = 'public/images/users';
            $avatar = $request->file('avatar');
            $avatar_name = $avatar->getClientOriginalName();
            $path = $request->file('avatar')->storeAs($destination_path, $avatar_name);
            $user->avatar = $avatar_name;
            }

        $user->save();
        $user_posts = $user->posts()->get();
        return response()->json(['user'=>$user,'user_posts'=>$user_posts, 200]);
    }

}






