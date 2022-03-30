<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function getAllPosts() {
        return response()->json(Post::orderBy('id','ASC')->with('user')->get());
    }

    public function addPost(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:1|max:150',
            'content' => 'required|min:1|max:300',
            'tag' => 'required|min:1|max:150',
            'user_id' => 'min:1|max:100',
            'image' => 'required',
        ]);
    
        $errors = $validator->errors();
            if($errors->any()){
                return response()->json($errors, 400);
            }
    
        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->tag = $request->tag;
        $post->user_id = $request->user()->id;

        if($request->hasFile('image')) {
        $destination_path = 'public/images/posts';
        $image = $request->file('image');
        $image_name = $image->getClientOriginalName();
        $path = $request->file('image')->storeAs($destination_path, $image_name);
        $post->image = $image_name;
        }
        $post->save();
        
        return response()->json(['post' => $post, 'message' => 'Your post was created!' , 200]);
    }


}

