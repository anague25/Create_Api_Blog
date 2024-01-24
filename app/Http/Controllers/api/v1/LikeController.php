<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Models\api\v1\Article;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function likeOrUnlike(Article $post )
    {
        if(!$post)
        {
            return response()->json([
                'status' => 0,
                'message' => 'post not found'
            ],404);
        }

        $like = $post->userLike()->where('user_id',auth()->user()->id)->first();

        // if not liked then like


        if(!$like)
        {
           $post->userLike()->attach(auth()->user()->id);

           return response()->json([
               'status' => 1,
               'message' => 'liked'
           ],200);
        }else{
            //dislike
           
            $post->userLike()->detach(auth()->user()->id);

           return response()->json([
               'status' => 1,
               'message' => 'disliked'
           ],200);
        }




    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
