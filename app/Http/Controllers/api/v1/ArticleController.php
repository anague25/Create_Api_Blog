<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Requests\api\v1\article\ArticleUpdateRequest;
use Illuminate\Http\Request;
use App\Models\api\v1\Article;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\api\v1\article\ArticleStoreRequest;

class ArticleController extends Controller
{
    /**
     * get all post
     */
    public function index()
    {
       return response()->json([
            'status' => 1,
            'posts' => Article::orderByDesc('created_at')->with('user:id,firstName,lastName,image')->withCount('comment','userLike')->get()
       ],200);
    }

   

    /**
     * create post or article
     */
    public function store(ArticleStoreRequest $request)
    {
       $post = new Article();

       $dataValidated = $this->storeAndUpdateImage($request, $post);
       $dataValidated['user_id'] = Auth::user()->id;
        $data = Article::create($dataValidated);
        return response()->json([
            'message' => 'Post created',
            'post' => $data
        ]);
    }


     /**
     * store or update image
     */
    public function storeAndUpdateImage($request, $post)
    {

        $data = $request->validated();

        $image = $request->validated('image');
        if ($image == null || $image->getError()) {
            return $data;
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $data['image'] = $image->store('post', 'public');
        return $data;
    }

    /**
     * Get single post
     */
    public function show(Article $post)
    {
        return response()->json([
            'status' => 1,
            'post' => Article::where('id',$post->id)->withCount('comment','userLike')->get()
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

        $dataValidated = $this->storeAndUpdateImage($request, $post);

         $data = $post->update($dataValidated);
         return response()->json([
            'status' => 1,
             'message' => 'Post updated',
             'post' => $data
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

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->comment()->delete();
        $post->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Post deleted.'
        ],200);


    }
}
