<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

use \Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Auth;

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

            // dd($request->all());
            $result = Post::create($request->validated());


            return response([
                'message' => "Post created succesfully",
                "post" => new PostResource($result)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function show(string $slug)
    {

        try {
            $post = Post::where("slug", $slug)->first();

            return response(new PostResource($post));
        } catch (\Exception $e) {

            // \Log::error(json_encode($e));
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function update(CreatePostRequest $request, int $id)
    {
        try {
            $post = Post::findOrFail($id);

            $result = $post->update($request->validated());
            if ($result) {
                return response()->json([
                    "status" => 200,
                    "message" => "Post updated succesfully"
                ]);
            }

            return;
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function destroy(int $id)
    {
        try {
            $post = Post::findOrFail($id);
            $result = $post->delete();
            if ($result) {
                return response()->json([
                    "Message" => "Post was deleted",
                    "post" => $post
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ]);
        }
    }
}
