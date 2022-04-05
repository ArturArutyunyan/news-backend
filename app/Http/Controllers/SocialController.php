<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;

class SocialController extends Controller
{
    public function googleRedirect(Request $request) 
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->name = $request->name;
            $user->avatar = $request->imageUrl;
            $token = $user->createToken('login')->accessToken;
            $user->save();
            return response()->json(['user'=>$user, 'token'=>$token, 200]);           
        } else {
            $user = new User;
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=Hash::make("user");
            $user->avatar=$request->imageUrl;

            $user->save();
            $token = $user->createToken('login')->accessToken;
                return response()->json(['user'=>$user, 'token'=>$token, 200]);
        }
    }
}


