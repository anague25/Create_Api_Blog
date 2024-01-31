<?php

namespace App\Http\Controllers\api\v1\admin;

use Exception;
use App\Models\User;
use App\Models\api\v1\Article;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\api\v1\admin\article\ArticleStoreRequest;
use App\Http\Requests\api\v1\admin\article\ArticleUpdateRequest;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       try
       {

        if(Gate::denies('admin-redacteur-reader-action'))
        {
            return response()->json([
                'status' => 0,
                'message' => 'Permission denied'
            
            ]);
        }
       
        return response()->json([
            'status' => 1,
            'posts' =>Article::orderByDesc('created_at')
            ->with('user:id,firstName,lastName,image','tag','category','comment','like')
            ->withCount('comment','like')
           ->get()
                    ],200);

       }catch(Exception $e)
       {
            return response()->json($e);
       }

    }



    /**
     * Get single post
     */
    public function show(Article $post)
    {
        return response()->json([
            'status' => 1,
            'post' => Article::where('id',$post->id)
            ->with('user:id,firstName,lastName,image','tag','category','comment','like')
            ->withCount('comment','like')->get()
        ],200);
    }


    public function store(ArticleStoreRequest $request ,User $user)
    {
       try
       {

        if(Gate::denies('admin-redacteur-action')){
            return response()->json([
                'status' => 0,
                'message' => 'Permission denied'
            
            ]);
        }

        $post = new Article();

        $dataValidated = $this->storeAndUpdateImage($request, $post,$folderNameImage='post');
        $dataValidated['user_id'] = $user->id;
         $data = Article::create($dataValidated);
         $data->tag()->sync($request->validated('tags'));
 
         return response()->json([
             'message' => 'Article created',
             'post' => $data
         ]);

       }catch(Exception $e)
       {
            return response()->json($e);
       }
    }
   
   


    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleUpdateRequest $request, Article $post, User $user)
    {
        try
       {

        if(Gate::denies('admin-redacteur-action')){
            return response()->json([
                'status' => 0,
                'message' => 'Permission denied'
            
            ]);
        }
    
        
        if(!$post){
            return response()->json([
                'status' => 0,
                'message' => 'Post not found',
            ],404);
           }
    
           if($post->user_id != $user->id)
           {
            return response()->json([
                'status' => 0,
                'message' => 'Permission denied',
            ],403);
           }
    
            $dataValidated = $this->storeAndUpdateImage($request, $post,$folderNameImage='post');
    
             $post->update($dataValidated);
             $post->tag()->sync($request->validated('tags'));
    
             return response()->json([
                'status' => 1,
                 'message' => 'Post updated',
                 'post' => $post
             ],200);

       }catch(Exception $e)
       {
            return response()->json($e);
       }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $post, User $user)
    {
       try
       {
         // admin-redacteur-users
         if(!$post){
            return response()->json([
                'status' => 0,
                'message' => 'Post not found'
            ],404);
        }
        
        if($post->user_id != $user->id )
        {
            return response()->json([
                'status' => 0,
                'message' => 'Permission denied'
            ],403);
        }

        // dd($post->like()->get());

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->comment()->delete();
        $post->like()->delete();
        $post->tag()->sync([]);
        $post->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Post deleted.'
        ],200);

       }catch(Exception $e)
       {
            return response()->json($e);
       }
    }
}
