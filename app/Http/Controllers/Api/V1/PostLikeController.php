<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function like(Request $request, Post $post)
    {
//        dd(auth()->user());
        auth()->user()->like($post);

        return response()->json(['message' => 'Success']);
    }

    public function unlike(Request $request, Post $post)
    {
        auth()->user()->unlike($post);

        return response()->json(['message' => 'Success']);
    }

    public function dislike(Request $request, Post $post){
    auth()->user()->dislike($post);

    return response()->json(['message' => 'Success']);
}

public function userLikes(){
        $likes  = Like::query()->whereMorphedTo('userable', auth()->user())->get();
        return response()->json($likes);
}

public function postLikes(Post $post){
    $likes = Post::withCount(['likes', 'dislikes'])->find($post->id);
//    dd($likes);

    return response()->json($likes);

}
}
