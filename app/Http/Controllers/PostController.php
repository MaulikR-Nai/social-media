<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function index()
    {
        $getAllPosts = Post::with(['user','comments.user','likes'])->get();


        return response()->json(
            ['all_posts' => $getAllPosts]
        );
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',

        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $post = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'uploads');
            $post['image'] = $imagePath;
        }


        $status = Post::create($post);

        return response()->json([
            'msg' => 'Post Created'
        ]);
    }
}
