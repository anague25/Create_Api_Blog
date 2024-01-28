<?php

use App\Http\Controllers\api\v1\ArticleController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\CommentController;
use App\Http\Controllers\api\v1\LikeController;
use App\Http\Controllers\api\v1\SearchController;
use App\Http\Controllers\api\v1\TagController;
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
    //user would like to detroy his account (delete my account) 
    Route::delete('/user/destroy',[UserController::class,'destroy']);
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
    Route::post('/posts/{post}/update',[ArticleController::class,'update']);
    //delete post
    Route::delete('/posts/{post}',[ArticleController::class,'destroy']);
});


/** Route to manage comment  */

Route::middleware('auth:sanctum')->group(function(){
    //get all comment of a post
    Route::get('/posts/{post}/comments',[CommentController::class,'index']);
    //create comment
    Route::post('/posts/{post}/comments',[CommentController::class,'store']);
    //updade comment
    Route::put('/comments/{comment}/update',[CommentController::class,'update']);
    //delete comment
    Route::delete('/comments/{comment}',[CommentController::class,'destroy']);
});


/** Route to manage comment  */

Route::middleware('auth:sanctum')->group(function(){
    //get all comment of a post
    Route::get('/posts/{post}/comments',[CommentController::class,'index']);
    //create comment
    Route::post('/posts/{post}/comments',[CommentController::class,'store']);
    //updade comment
    Route::put('/comments/{comment}/update',[CommentController::class,'update']);
    //delete comment
    Route::delete('/comments/{comment}',[CommentController::class,'destroy']);
});

/** Route to manage category  */

Route::middleware('auth:sanctum')->group(function(){
    //get all categories that user has created
    Route::get('/category',[CategoryController::class,'index']);
    //create category
    Route::post('/category',[CategoryController::class,'store']);
    //updade category
    Route::post('/category/{category}/update',[CategoryController::class,'update']);
    //delete category
    Route::delete('/category/{category}/delete',[CategoryController::class,'destroy']);
});

/** Route to manage tags  */
Route::middleware('auth:sanctum')->group(function(){
    //get all tags that user has created
    Route::get('/tags',[TagController::class,'index']);
    //to create tags
    Route::post('/tags',[TagController::class,'store']);
    //updade tags
    Route::post('/tags/{tag}/update',[TagController::class,'update']);
    //delete category
    Route::delete('/tags/{tag}/delete',[TagController::class,'destroy']);
});

/** Route to manage search  */

Route::middleware('auth:sanctum')->group(function(){
    //you can search by title,content,author,tag,category,
    Route::get('/searchs',[SearchController::class,'search']);

   
});

/** Route to manage like  */

Route::middleware('auth:sanctum')->group(function(){
    //like or dislike post
    Route::post('/posts/{post}/likes',[LikeController::class,'likeOrUnlike']);
});

