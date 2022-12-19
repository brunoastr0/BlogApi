<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\PostCommentController;
use App\Http\Controllers\Api\V1\PostController;

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
    Route::apiResource('post.comment', CommentController::class);
    Route::delete('/post/{post}/comments/{comment}', [PostCommentController::class, 'destroy'])->name('post-comment.destroy');

    /* Route::get('/post', [PostController::class, 'index']);
     Route::post('/post', [PostController::class, 'store'])->name('post.store');
     Route::post('/post/{id}/comment', [CommentController::class, 'create']);
     Route::get('/post/{slug}', [PostController::class, 'show']);
     Route::delete('/post/delete/{id}', [PostController::class, 'destroy']);
     Route::put('/post/edit/{post}', [PostController::class, 'update'])->name('post.update');*/



    /**Author routes */
    Route::post('/logout', [AuthorController::class, 'logout'])->name('logout');
    Route::get('/author', [AuthorController::class, 'index']);
});

/**Public Routes */
Route::get('/post',[PostController::class,'index'])->name('post.index');
Route::get('/lastweek', [PostController::class, 'LastWeekPosts']);

Route::post('/login', [AuthorController::class, 'login']);
Route::post('/register', [AuthorController::class, 'register']);
