<?php

namespace App\Http\Controllers;
use App\Models\Post;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function getAllPosts() {
        return response()->json(Post::orderBy('id','ASC')->get());
    }
}
