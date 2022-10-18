<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**Article routes */
Route::get('/post', [ArticleController::class, 'index']);
Route::post('/post', [ArticleController::class, 'store']);
Route::get('/post/{id}', [ArticleController::class, 'show']);
Route::delete('/post/{id}', [ArticleController::class, 'destroy']);
Route::put('/post/{id}', [ArticleController::class, 'update']);

/**Author routes */
Route::post('/login', [AuthorController::class, 'login'])->name('login');
Route::post('/logout', [AuthorController::class, 'logout'])->middleware("auth:api");
Route::post('/register', [AuthorController::class, 'register']);
Route::get('/getAuthor', [AuthorController::class, 'getAuthor'])->middleware("auth:api");
