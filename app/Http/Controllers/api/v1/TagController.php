<?php

namespace App\Http\Controllers\api\v1;

use Exception;
use App\Models\api\v1\Tag;
use Illuminate\Http\Request;
use App\Models\api\v1\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\tags\TagStoreRequest;
use App\Http\Requests\api\v1\tags\TagUpdateRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 1,
            'tag' => Tag::where('user_id',auth()->user()->id)->get()

           
                                ],200);

    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(TagStoreRequest $request)
    {
        try{
        
            $dataValidated = $request->validated();
            $dataValidated['user_id'] = auth()->user()->id; 
            $tags = Tag::create($dataValidated);
              return response()->json([
                  'message' => 'Tag created',
                  'category' => $tags
              ]);
  
          }catch(Exception $e){
              return response()->json($e);
          }
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
    public function update(TagUpdateRequest $request, Tag $tag)
    {
        try{

            if(!$tag){
                return response()->json([
                    'status' => 0,
                    'message' => 'tag not found',
                ],404);
               }
        
               if($tag->user_id != auth()->user()->id)
               {
                return response()->json([
                    'status' => 0,
                    'message' => 'Permission denied',
                ],403);
               }

             $tag->update($request->validated());
             return response()->json([
                'status' => 1,
                 'message' => 'Tag updated'
             ],200);

        }catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        try{
           
            if(!$tag){
                return response()->json([
                    'status' => 0,
                    'message' => 'tag not found'
                ],404);
            }
            
            if($tag->user_id != auth()->user()->id )
            {
                return response()->json([
                    'status' => 0,
                    'message' => 'Permission denied'
                ],403);
            }
    
            $tag->delete();
    
            return response()->json([
                'status' => 1,
                'message' => 'tag deleted.'
            ],200);
        }
        catch(Exception $e)
        {
            return response()->json($e);
        }
    }
}
