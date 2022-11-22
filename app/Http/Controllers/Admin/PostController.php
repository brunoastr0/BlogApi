<?php

namespace App\Http\Controllers\Admin;

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
        $posts =  Post::with("users")->orderBy("creadted_at")->get();
        return response(
            ["post" => PostResource::collection($posts)]
        );
    }
}
