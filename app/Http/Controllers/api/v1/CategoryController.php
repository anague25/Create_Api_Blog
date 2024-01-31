<?php

namespace App\Http\Controllers\api\v1;

use Exception;

use App\Models\api\v1\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\categories\CategoryStoreRequest;
use App\Http\Requests\api\v1\categories\CategoryUpdateRequest;
use App\Models\api\v1\Article;
use App\Models\User;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 1,
            'categories' => Category::where('user_id',auth()->user()->id)->get()

            // 'category' => Category::with('user')->where('user_id',auth()->user()->id)->get(),
                                ],200);

    }

    public function show(Category $category)
    {
        return response()->json([
            'status' => 1,
            'category' => $category

                                ],200);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        try{
        
          $dataValidated = $request->validated();
          $dataValidated['user_id'] = auth()->user()->id; 
         $category = Category::create($dataValidated);
            return response()->json([
                'message' => 'Category created',
                'category' => $category
            ]);

        }catch(Exception $e){
            return response()->json($e);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        try{

            if(!$category){
                return response()->json([
                    'status' => 0,
                    'message' => 'Category not found',
                ],404);
               }
        
               if($category->user_id != auth()->user()->id)
               {
                return response()->json([
                    'status' => 0,
                    'message' => 'Permission denied',
                ],403);
               }

             $category->update($request->validated());
             return response()->json([
                'status' => 1,
                 'message' => 'Category updated'
             ],200);

        }catch(Exception $e){
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try{
            if(!$category){
                return response()->json([
                    'status' => 0,
                    'message' => 'Post not found'
                ],404);
            }
            
            if($category->user_id != auth()->user()->id )
            {
                return response()->json([
                    'status' => 0,
                    'message' => 'Permission denied'
                ],403);
            }
            

            $posts = $category->article;
            if($posts){
                foreach($posts as $post)
                {
                    $post->category()->dissociate();
                    $post->save();
                }
            }
            $category->delete();
    
            return response()->json([
                'status' => 1,
                'message' => 'Category deleted.'
            ],200);
        }
        catch(Exception $e)
        {
            return response()->json($e);
        }
    }
}
