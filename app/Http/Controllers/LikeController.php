<?php

namespace App\Http\Controllers;

use App\Models\{Comment, Post,Like};
use Illuminate\Http\Request;



class LikeController extends Controller
{
    public function likePost(Request $request, Post $post)
    {
        $getUser = $request->user_id;

        $checkPostLikeExists = $post->likes()->where('user_id',$getUser)->exists();

        if($checkPostLikeExists) {
            return response()->json([
                'error' => 'You already like it',
            ]);
        }

        if($getUser == $post->user_id) {
            return response()->json([
                'error' => 'You cannot like your post',
            ]);
        }

        $like = new Like([
            'user_id' => $getUser,
            'likeable_id' => $post->id,
            'likeable_type' => 'posts',
        ]);

        $like->save();
        //$post->likes()->save($like);

        return response()->json([
            'msg' => 'Post Liked',
        ]);
    }

    public function dislikePost(Request $request,$user_id,Post $post)
    {
        $getUser = $user_id;

        $findLike = like::where('user_id',$getUser)->first();

        if(!$findLike) {
            return response()->json([
                'error' => 'You not like post'
            ]);
        }

        $findLike->delete();

        return response()->json([
            'msg' => 'Dislike post',
        ]);
    }

    public function likeComment(Request $request, Comment $comment)
    {
        $getUser = $request->user_id;

        $checkPostLikeExists = $comment->likes()->where('user_id',$getUser)->exists();
        if($checkPostLikeExists) {
            return response()->json([
                'error' => 'You already like it',
            ]);
        }

        if($getUser == $comment->user_id) {
            return response()->json([
                'error' => 'You cannot like your comment',
            ]);
        }

        $comments = new Like([
            'user_id' => $getUser,
            'likeable_id' => $comment->id,
            'likeable_type' => 'comments',
        ]);

        $comments->save();

        return response()->json([
            'msg' => 'Comment Liked',
        ]);
    }

    public function dislikeComment(Request $request,$user_id,Comment $comment)
    {
        $getUser = $user_id;

        $findLike = Like::where('user_id',$getUser)->first();



        if(!$findLike) {
            return response()->json([
                'error' => 'You not like comment'
            ]);
        }

        $findLike->delete();

        return response()->json([
            'msg' => 'Dislike comment',
        ]);
    }
}
