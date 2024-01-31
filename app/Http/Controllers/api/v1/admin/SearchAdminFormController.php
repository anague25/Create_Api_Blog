<?php

namespace App\Http\Controllers\api\v1\admin;

use Exception;
use App\Models\User;
use App\Models\api\v1\Article;
use App\Models\api\v1\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\api\v1\admin\searchs\SearchFormRequest;

class SearchAdminFormController extends Controller
{
    public function search(SearchFormRequest $request){
    

       try{

        if(Gate::denies('reader-action'))
        {
            return response()->json([
                'status' => 0,
                'message' => 'Permission denied'
            
            ]);
        }



        if($request->validated('title'))
        {
            $title = $request->validated('title');

            $query = Article::where('title','like','%'.$title.'%')->get();
            
        }

        
        if($request->validated('category'))
        {
            $category = $request->validated('category');

            $query = Category::with('article')->where('name','like','%'.$category.'%')->get();
            
        }
        
      

        if(!$request->validated()){
            return response()->json([
                'status' => 0,
                'search' => 'fill in the field'
            ],404);
        }

        if($query->isEmpty()){
            return response()->json([
                'status' => 0,
                'search' => 'no results found'
            ],404);
        }

       

        return response()->json([
           'status' => 1,
            'search' => $query,
        ],200);

       }catch(Exception $e){
            return response()->json($e);
       }

    }
}
