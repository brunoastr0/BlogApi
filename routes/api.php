<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\PostCommentController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\PostLikeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::resources('/post', PostController::class);
/**Private Routes */
Route::group(["middleware" => "auth:sanctum"], function () {
    /**Admin */
    Route::group([
        'prefix' => "admin",
        'middleware' => 'is_admin',
        'as' => 'admin'
    ], function () {
        Route::get('/post', [PostController::class, 'index']);
    });

    /**Artcile Routes */
    Route::apiResource('post', PostController::class)->except('index');
    Route::apiResource('post.comment', CommentController::class)->except("show");
    Route::delete('/post/{post}/comments/{comment}', [PostCommentController::class, 'destroy'])->name('post-comment.destroy');

    /**Author routes */
    Route::post('/logout', [AuthorController::class, 'logout'])->name('logout');
    Route::get('/author', [AuthorController::class, 'index']);

    /** Post Likes */
    Route::post('/post/{post}/like', [PostLikeController::class, 'like'])->name('post.like');
    Route::post('/post/{post}/unlike', [PostLikeController::class, 'unlike'])->name('post.unlike');
    Route::get('/post/{post}/likes',[PostLikeController::class, 'postLikes'])->name('post.like.count');
//    Route::get('/user/likes', [PostLikeController::class, 'userLikes'])->name('user.likes');

});

/**Public Routes */
Route::get('/post',[PostController::class,'index'])->name('post.index');
Route::get('/lastweek', [PostController::class, 'LastWeekPosts']);

Route::post('/login', [AuthorController::class, 'login']);
Route::post('/register', [AuthorController::class, 'register']);




/*Route::group(Route::controller(PostLikeController::class, function (){
    Route::post('/post/{post}/like','like')->name("post.like");
}));*/
