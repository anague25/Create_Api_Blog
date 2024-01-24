<?php

use App\Http\Controllers\api\v1\ArticleController;
use App\Http\Controllers\api\v1\CommentController;
use App\Http\Controllers\api\v1\LikeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


/** Route to manage user */

Route::post('/register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){
    //update user
    Route::put('user/{user}/update',[UserController::class,'update']);
    //disconnexion
    Route::post('logout',[UserController::class,'logout']);
    //get user information
    Route::get('/user',[UserController::class,'user']);
});


/** Route to manage article or post */

Route::middleware('auth:sanctum')->group(function(){
    //get all posts or article
    Route::get('/posts',[ArticleController::class,'index']);
    //create post
    Route::post('/posts',[ArticleController::class,'store']);
    //get single post
    Route::get('/posts/{post}',[ArticleController::class,'show']);
    //updade post
    Route::put('/posts/{post}/update',[ArticleController::class,'update']);
    //delete post
    Route::delete('/posts/{post}',[ArticleController::class,'destroy']);
});


/** Route to manage comment  */

Route::middleware('auth:sanctum')->group(function(){
    //get all comment of a post
    Route::get('/posts/{post}/comments',[CommentController::class,'index']);
    //create post
    Route::post('/posts/{post}/comments',[CommentController::class,'store']);
    //updade post
    Route::put('/comments/{comment}/update',[CommentController::class,'update']);
    //delete post
    Route::delete('/comments/{comment}',[CommentController::class,'destroy']);
});

/** Route to manage like  */

Route::middleware('auth:sanctum')->group(function(){
    //like or dislike post
    Route::post('/posts/{post}/likes',[LikeController::class,'likeOrUnlike']);
});

