<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PostController;

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
    Route::get('/post', [PostController::class, 'index']);
    Route::post('/post', [PostController::class, 'store']);
    Route::get('/post/{slug}', [PostController::class, 'show']);
    Route::delete('/post/delete/{id}', [PostController::class, 'destroy']);
    Route::put('/post/edit/{id}', [PostController::class, 'update']);

    /**Author routes */
    Route::post('/logout', [AuthorController::class, 'logout']);
    Route::get('/author', [AuthorController::class, 'index']);
});

/**Public Routes */

Route::post('/login', [AuthorController::class, 'login'])->name('login');
Route::post('/register', [AuthorController::class, 'register']);
