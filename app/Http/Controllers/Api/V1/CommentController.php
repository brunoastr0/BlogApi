<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }


    public function store(CreateCommentRequest $request, Post $post)
    {

        try {
            $request['post_id'] = $post->id;


            $comment = Comment::create($request->validated());

            return response()->json('',Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e -> getMessage()
            ]);
        }
    }



    public function show(Comment $comment)
    {
    }




    public function update(Request $request, Comment $comment)
    {
        //
    }


    public function destroy(Post $post, Comment $comment)
    {
        try {
            $response = Gate::inspect('author-post-actions',$comment);
            if(!$response->allowed()){
                return response()->json('',$response->status());
            }

            $comment->delete();

            return response()->json('',Response::HTTP_NO_CONTENT);

        }catch (\Exception $exception){
            return response()->json([
                "error"=>$exception->getMessage()
            ]);
        }
    }
}
