<?php

namespace App\Http\Controllers\api\v1;

use App\Models\api\v1\Article;
use App\Models\api\v1\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\comment\CommentStoreRequest;
use App\Http\Requests\api\v1\comment\CommentUpdateRequest;

class CommentController extends Controller
{
    /**
     * get all comment of a post.
      
     */
    
    
     public function index($id)
    {
        $post = Article::find($id);
       
        if(!$post){
            return response()->json([
                'status' => 0,
                'message' => 'Post not found'
            ],404);
        }

        return response()->json([
            'status' => 1,
            'comments' => $post->comment()->with('user:id,firstName,lastName,image')->get()
        ],200);
    }



     /**
     * Get single post
     */
    public function show(Comment $comment)
    {
        return response()->json([
            'status' => 1,
            'comment' => $comment
        ],200);
    }

    

    /**
     * create comment
     */
    public function store(CommentStoreRequest $request,Article $post)
    {
        if(!$post){
            return response()->json([
                'status' => 0,
                'message' => 'Post not found'
            ],404);
        }

        $dataValidated = $request->validated();
        $dataValidated['article_id'] = $post->id;
        $dataValidated['user_id'] = auth()->user()->id;
        // dd($dataValidated);

        Comment::create($dataValidated);

        return response()->json([
            'status' => 1,
            'message' => 'comment created',
        ],200);
    }

  

    /**
     * Update comment.
     */
    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        if(!$comment){
            return response()->json([
                'status' => 0,
                'message' => 'comment not found'
            ],404);
        }

        if($comment->user_id != auth()->user()->id){
            return response()->json([
                'status' => 0,
                'message' => 'permission denied'
            ],403);
        }


        $dataValidated = $request->validated();
        $comment->update($dataValidated);

        return response()->json([
            'status' => 1,
            'message' => 'comment updated',
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if(!$comment)
        {
            return response()->json([
                'status' => 0,
                'message' => 'comment not found'
            ],404);
        }

        if($comment->user_id != auth()->user()->id)
        {
            return response()->json([
                'status' => 0,
                'message' => 'permission denied'
            ],403);
        }

        
        $comment->delete();

        return response()->json([
            'status' => 1,
            'message' => 'comment deleted',
        ],200);
    }
}
