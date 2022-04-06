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
        $currentUser = $user ? $user : new User;

        if (!$user) {
            $currentUser->email=$request->email;
            $currentUser->password=Hash::make("user");
        }

        $currentUser->name = $request->name;
        $currentUser->avatar = $request->imageUrl; 

        $currentUser->save();
        $token = $currentUser->createToken('login')->accessToken;
            return response()->json(['user'=>$currentUser, 'token'=>$token, 200]);
    }
}


