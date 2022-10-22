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
            if ($posts) {
                return PostResource::collection($posts);
            }
            return response(status: 404);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ]);
        }
    }



    public function store(CreatePostRequest $request)
    {

        try {

            // dd(auth()->id());


            // $result = post::create($request->validate([
            //     'title' => 'required | string',
            //     'post' => 'required | string',
            //     'slug' => 'required | string',
            //     'author_id' => 'int|exists:users,id'
            // ]));
            $result = Post::create($request->validated());





            if ($result) {
                return response([
                    'message' => "Post created succesfully",
                    "post" => $result
                ], status: 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function show(int $id)
    {

        try {
            $post = Post::findOrFail($id);
            if ($post) {
                return $post;
                return PostResource::collection($post);
            }
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
