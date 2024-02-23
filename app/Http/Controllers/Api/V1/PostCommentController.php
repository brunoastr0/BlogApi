<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PostCommentController extends Controller
{

    public function destroy(Post $post, Comment $comment){
        try {
            $response = Gate::inspect('author-post-actions',$post);
            if(!$response->allowed()){
                return response()->json('',$response->status());
            }

            $comment->delete();

            return response()->json('',Response::HTTP_NO_CONTENT);

        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ]);
        }

    }

}
