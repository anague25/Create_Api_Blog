<?php

use App\Http\Controllers\api\v1\admin\ArticlesController;
use App\Http\Controllers\api\v1\admin\CommentsController;
use App\Http\Controllers\api\v1\admin\RolesController;
use App\Http\Controllers\api\v1\admin\SearchAdminFormController;
use App\Http\Controllers\api\v1\admin\UsersController;
use App\Http\Controllers\api\v1\ArticleController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\CommentController;
use App\Http\Controllers\api\v1\LikeController;
use App\Http\Controllers\api\v1\SearchController;
use App\Http\Controllers\api\v1\TagController;
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



/** Route for administrator */
Route::middleware('auth:sanctum')->group(function(){
  
//-------------------------------ADMIN MANAGE USERS -------------------------------------------------------------------------------------------------------//

        Route::prefix('admin')->group(function(){
                //get all user 
            Route::get('/user',[UsersController::class ,'index']);
            //get single user
            Route::get('/user/{user}/show',[UsersController::class,'show']);
            //updade user
            Route::post('/user/{user}/update',[UsersController::class,'update']);
            //delete user
            Route::delete('/user/{user}/destroy',[UsersController::class,'destroy']);


//-------------------------------ADMIN MANAGE ARTICLES ----------------------------------------------------------------------------------------------------//
            //get all articles and theirs users,categories,comments,like, number of like , number of comments
            Route::get('/post',[ArticlesController::class ,'index']);
            //get single articles and her user,category,comments,likes, number of likes , number of comments 
            Route::get('/post/{post}/show',[ArticlesController::class,'show']);
            //updade a user is article
            Route::post('/post/{post}/{user}/update',[ArticlesController::class,'update']);
            //delete a user is article
            Route::delete('/post/{post}/{user}/destroy',[ArticlesController::class,'destroy']);


//-----------------------------------------ADMIN MANAGE ROLES ------------------------------------------------------------------------------------------//
            //get all roles 
            Route::get('/roles',[RolesController::class ,'index']);
            //delete role
            Route::delete('/role/{role}/destroy',[RolesController::class,'destroy']);



//-----------------------------------------ADMIN MANAGE SEARCH ------------------------------------------------------------------------------------------//
           

            //you can search by title,category
            Route::get('/search',[SearchAdminFormController::class ,'search']);
           


//----------------------------------------- MANAGE COMMENTS ------------------------------------------------------------------------------------------//
            //create comments 
            Route::post('/comment/{post}',[CommentsController::class ,'store']);
           



        });
})->middleware('can:admin-redacteur-reader-action');


//-----------------------------------------END ADMIN ------------------------------------------------------------------------------------------//










//-----------------------------------------START USERS ------------------------------------------------------------------------------------------//


//-----------------------------------------ROUTE MANAGE USERS ------------------------------------------------------------------------------------------//

//route to register user
Route::post('/register',[UserController::class,'register']);
//route to login user
Route::post('login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){
    //update user
    Route::post('users/{user}/update',[UserController::class,'update']);
    //disconnexion
    Route::post('logout',[UserController::class,'logout']);
    //get all user
    Route::get('/users',[UserController::class,'index']);
    //get single user informations
    Route::get('/users/show',[UserController::class,'show']);
    //user would like to detroy his account (delete my account) 
    Route::delete('/users/destroy',[UserController::class,'destroy']);
});


//----------------------------------------- ROUTE TO MANAGE ARTICLE OR POST -----------------------------------------------------------------------//
Route::middleware('auth:sanctum')->group(function(){
    //get all articles and theirs users,categories,comments,like, number of like , number of comments
    Route::get('/posts',[ArticleController::class,'index']);
    //create article
    Route::post('/posts',[ArticleController::class,'store']);
    //get single article and her user,category,comments,likes, number of likes , number of comments
    Route::get('/posts/{post}',[ArticleController::class,'show']);
    //updade article
    Route::post('/posts/{post}/update',[ArticleController::class,'update']);
    //delete article
    Route::delete('/posts/{post}',[ArticleController::class,'destroy']);
});


//----------------------------------------- ROUTE TO MANAGE COMMENTS -----------------------------------------------------------------------//
Route::middleware('auth:sanctum')->group(function(){
    //get all comment of a post
    Route::get('/comments/{post}',[CommentController::class,'index']);
     //get single comment
     Route::get('/comments/{comment}',[CommentController::class,'show']);
    //create comment
    Route::post('/comments/{post}',[CommentController::class,'store']);
    //updade comment
    Route::post('/comments/{comment}/update',[CommentController::class,'update']);
    //delete comment
    Route::delete('/comments/{comment}',[CommentController::class,'destroy']);
});





//----------------------------------------- ROUTE TO MANAGE CATEGORIES -----------------------------------------------------------------------//
Route::middleware('auth:sanctum')->group(function(){
    //get all categories that user has created
    Route::get('/category',[CategoryController::class,'index']);
     //get single category
     Route::get('/category/{category}',[CategoryController::class,'show']);
    //create category
    Route::post('/category',[CategoryController::class,'store']);
    //updade category
    Route::post('/category/{category}/update',[CategoryController::class,'update']);
    //delete category
    Route::delete('/category/{category}/delete',[CategoryController::class,'destroy']);
});


//----------------------------------------- ROUTE TO MANAGE TAGS -----------------------------------------------------------------------//
Route::middleware('auth:sanctum')->group(function(){
    //get all tags that user has created
    Route::get('/tags',[TagController::class,'index']);
     //get single tags
     Route::get('/tags/{tag}',[TagController::class,'show']);
    //to create tags
    Route::post('/tags',[TagController::class,'store']);
    //updade tags
    Route::post('/tags/{tag}/update',[TagController::class,'update']);
    //delete tags
    Route::delete('/tags/{tag}/delete',[TagController::class,'destroy']);
});



//----------------------------------------- ROUTE TO MANAGE SEARCHS -----------------------------------------------------------------------//
Route::middleware('auth:sanctum')->group(function(){
    //you can search by title,content,author,tag,category
    Route::get('/searchs',[SearchController::class,'search']);

   
});



//----------------------------------------- ROUTE TO MANAGE LIKES -----------------------------------------------------------------------//
Route::middleware('auth:sanctum')->group(function(){
    //like or dislike post
    Route::post('/posts/{post}/likes',[LikeController::class,'likeOrUnlike']);
});

