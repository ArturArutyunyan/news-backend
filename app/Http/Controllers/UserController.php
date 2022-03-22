<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
            'password' => 'required|min:6'
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
            return response()->json($token, 200);
    }
 
}




