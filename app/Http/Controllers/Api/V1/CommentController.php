<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;


class CommentController extends Controller
{
    public function index(Post $post)
    {
        try {
            $comments = Comment::where(['post_id'=>$post->id])->get();

            return response()->json(
               [ CommentResource::collection($comments)],
                Response::HTTP_OK
            );

        }catch (\Exception $exception){
            return response()->json(
                [
                    "error"=>$exception->getMessage()
                ]
            );
        }
    }


    public function store(CreateCommentRequest $request, Post $post)
    {
        try {
            $comment = Comment::create($request->validated());
            $comment->post_id = $post->id;
            $comment->save();
            return response()->json([],Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e -> getMessage()
            ]);
        }
    }

    public function update(UpdateCommentRequest $request,Post $post, Comment $comment)
    {
        try {

            $response = Gate::inspect('author-post-actions',$comment);
            if(!$response->allowed()){
                return response()->json('',$response->status());
            }

            if(!$post->comments()->where(["id"=>$comment->id])){
                return response([],Response::HTTP_NOT_FOUND);
            }
            $comment->update($request->validated());
            return response()->json([],Response::HTTP_OK);

        }catch (\Exception $exception){
            return response()->json([
                "error"=>$exception->getMessage()
            ]);
        }
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
