<?php

namespace App\Http\Controllers;

use App\Models\{Post,Comment};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        $getAllCommentsOnPost = $post->with(['comments','user','likes'])->get();

        return response()->json(['getAllCommentsOnPost' => $getAllCommentsOnPost]);
    }

    public function store(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(),
                [
                    'user_id' => 'required|exists:users,id',
                    'content' => 'required',
                ],
                [
                    'user_id.required' => 'User is required',
                ]
            );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

        $checkCommentExists = $post->comments()->where('user_id',$request->user_id)->exists();

        if($checkCommentExists) {
            return response()->json([
                'error' => 'You already Comment it',
            ]);
        }


        $comment = $request->all();
        $comment['post_id'] = $post->id;
        $status = Comment::create($comment);

        return response()->json([
            'msg' => 'Your Comment Add'
        ]);
    }
}
