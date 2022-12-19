<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Http\Controllers\Controller;


use \Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $posts = Post::all();

            if ($posts->isEmpty()) {
                return response(["message" => "No post available"], 404);
            }
            return response(PostResource::collection($posts));
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ]);
        }
    }



    public function store(CreatePostRequest $request)
    {

        try {

            $result = Post::create($request->validated());
            return response(
                new PostResource($result)
            , Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function show(string $slug)
    {

        try {

            $post = Post::where("slug", $slug)->get();






            return response(PostResource::collection($post));
        } catch (\Exception $e) {

            // \Log::error(json_encode($e));

            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


   public function update(Request $request, Post $post){
       try {
           $response = Gate::inspect('author-post-actions',$post);
         if(!$response->allowed()){
              return response()->json('',$response->status());
          }

            $post->updateOrFail($request->all());
            return response()->json('',Response::HTTP_OK);

       }catch (\Exception $exception){
           return response()->json([
               "error"=>$exception->getMessage()
           ]);
       }
   }

    public function destroy(int $id)
    {
        try {
            $post = Post::findOrFail($id);
            $response = Gate::inspect('author-post-actions',$post);
            if(!$response->allowed()){
                return response()->json('',$response->status());
            }


            $post->delete();

            return response()->json('',Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ]);
        }
    }


    public function LastWeekPosts()
    {
        return Post::lastWeek()->get();
    }
}
