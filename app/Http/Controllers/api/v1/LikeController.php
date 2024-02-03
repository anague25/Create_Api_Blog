<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Models\api\v1\Article;
use App\Http\Controllers\Controller;
use App\Models\api\v1\Like;
use Exception;

class LikeController extends Controller
{
    /**
     * like or dislike post.
     */
    public function likeOrUnlike(Article $post )
    {
       try{

        if(!$post)
        {
            return response()->json([
                'status' => 0,
                'message' => 'post not found'
            ],404);
        }

        $like = $post->like()->where('user_id',auth()->user()->id)->first();

        // if it not liked post then like

// dd($like);
        if(!$like)
        {
          Like::create([
            'liked' => 1,
            'article_id' => $post->id,
            'user_id' => auth()->user()->id
          ]);

           return response()->json([
               'status' => 1,
               'message' => 'liked'
           ],200);
        }else{
            //dislike
           
            $like->delete();

           return response()->json([
               'status' => 1,
               'message' => 'disliked'
           ],200);
        }


       }
       catch(Exception $e){
        return response()->json($e);
       }




    }

}

    