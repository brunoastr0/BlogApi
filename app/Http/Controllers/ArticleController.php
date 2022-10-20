<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

use \Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $articles = Article::all();
            if ($articles) {
                return ArticleResource::collection($articles);
            }
            return response(status: 404);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ]);
        }
    }



    public function store(CreateArticleRequest $request)
    {

        try {

            // dd(auth()->id());


            // $result = Article::create($request->validate([
            //     'title' => 'required | string',
            //     'post' => 'required | string',
            //     'slug' => 'required | string',
            //     'author_id' => 'int|exists:users,id'
            // ]));
            $result = Article::create($request->validated());





            if ($result) {
                return response("Article created succesfully", status: 201);
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
            $article = Article::findOrFail($id);
            if ($article) {
                return $article;
                return ArticleResource::collection($article);
            }
        } catch (\Exception $e) {

            // \Log::error(json_encode($e));
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    public function update(CreateArticleRequest $request, int $id)
    {
        try {
            $article = Article::findOrFail($id);

            $result = $article::create($request->validated());
            if ($result) {
                return response()->json([
                    "status" => 200,
                    "message" => "Article updated succesfully"
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
            $article = Article::findOrFail($id);
            if ($article) {
                return response()->json([
                    "Message" => "Article was deleted",
                    "Article" => $article
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ]);
        }
    }
}
