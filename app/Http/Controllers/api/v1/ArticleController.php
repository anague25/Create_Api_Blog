<?php

namespace App\Http\Controllers\api\v1;


use App\Models\api\v1\Article;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\api\v1\article\ArticleStoreRequest;
use App\Http\Requests\api\v1\article\ArticleUpdateRequest;

class ArticleController extends Controller
{
    /**
     * get all post
     */
    public function index()
    {
       return response()->json([
            'status' => 1,
            'posts' => Article::orderByDesc('created_at')
                        ->with('user:id,firstName,lastName,image','tag','category','comment')
                        ->withCount('comment','like')
                        ->with('like',function($liked){
                      return $liked->where('user_id',auth()->user()->id)
                       ->select('id','user_id','article_id')->get();
            })->get()
       ],200);

    }

   

    /**
     * create post or article
     */
    public function store(ArticleStoreRequest $request)
    {
       $post = new Article();

       $dataValidated = $this->storeAndUpdateImage($request, $post,$folderNameImage='post');
       $dataValidated['user_id'] = Auth::user()->id;
        $data = Article::create($dataValidated);
        $data->tag()->sync($request->validated('tags'));

        return response()->json([
            'message' => 'Post created',
            'post' => $data
        ]);
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

    

    /**
     * Update post.
     */
    public function update(ArticleUpdateRequest $request, Article $post)
    {
       if(!$post){
        return response()->json([
            'status' => 0,
            'message' => 'Post not found',
        ],404);
       }

       if($post->user_id != auth()->user()->id)
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
    }

    /**
     * delete post
     */
    public function destroy(Article $post)
    {
        if(!$post){
            return response()->json([
                'status' => 0,
                'message' => 'Post not found'
            ],404);
        }
        
        if($post->user_id != auth()->user()->id )
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

        $post->category()->dissociate();
        $post->save();
        $post->comment()->delete();
        $post->like()->delete();
        $post->tag()->sync([]);
        $post->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Post deleted.'
        ],200);


    }
}
