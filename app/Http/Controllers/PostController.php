<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Http\Controllers\Controller;


use \Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts =  Post::with("author")->orderBy("created_at")->latest()->limit(10)->get();

        return view('index', [
            'posts' => $posts
        ]);
    }



    // public function store(CreatePostRequest $request)
    // {

    //     try {

    //         // dd($request->all());
    //         $result = Post::create($request->validated());


    //         return response([
    //             'message' => "Post created succesfully",
    //             "post" => new PostResource($result)
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }


    // public function show(string $slug)
    // {

    //     try {

    //         $post = Post::where("slug", $slug)->get();




    //         return response(PostResource::collection($post));
    //     } catch (\Exception $e) {

    //         // \Log::error(json_encode($e));
    //         return response()->json([
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }


    // public function update(Request $request, int $id)
    // {
    //     try {
    //         $post = Post::findOrFail($id);
    //         $response = Gate::inspect('author-post-actions', $post);
    //         if ($response->allowed()) {
    //             $post->update($request->all());


    //             return response()->json([
    //                 "status" => 200,
    //                 "message" => "Post updated succesfully"
    //             ]);
    //         } else {
    //             return response(["message" => $response->message()], 403);
    //         }



    //         return;
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }


    // public function destroy(int $id)
    // {
    //     try {
    //         $post = Post::findOrFail($id);
    //         $response = Gate::inspect('author-post-actions', $post);
    //         if ($response->allowed()) {
    //             $result = $post->delete();

    //             return response()->json([
    //                 "status" => 200,
    //                 "message" => "Post deleted succesfully",
    //                 "post" => $post
    //             ]);
    //         } else {
    //             return response(["message" => $response->message()], 403);
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             "error" => $e->getMessage()
    //         ]);
    //     }
    // }


    // public function LastWeekPosts()
    // {
    //     return Post::lastWeek()->get();
    // }
}
