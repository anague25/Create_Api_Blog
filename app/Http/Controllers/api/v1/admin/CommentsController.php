<?php

namespace App\Http\Controllers\api\v1\admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\api\v1\Article;
use App\Models\api\v1\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\api\v1\admin\comments\CommentsStoreRequest;

class CommentsController extends Controller
{
   
     /**
     * create comment
     */
    public function store(CommentsStoreRequest $request,Article $post)
    {
        try{

            if(Gate::denies('reader-action'))
            {
                return response()->json([
                    'status' => 0,
                    'message' => 'Permission denied'
                
                ]);
            }

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

    }catch(Exception $e){
            return response()->json($e);
        }
    }
    


   
}
