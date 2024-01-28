<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\search\SearchFormRequest;
use App\Models\api\v1\Article;
use App\Models\api\v1\Category;
use App\Models\api\v1\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(SearchFormRequest $request){
       
        
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
        
        if($request->validated('content'))
        {
            $content = $request->validated('content');

            $query = Article::where('content','like','%'.$content.'%')->get();
            
        }
        if($request->validated('tag'))
        {
            $tag = $request->validated('tag');

            $query = Tag::with('article')->where('name','like','%'.$tag.'%')->get();
            
        }
        if($request->validated('author'))
        {
            $author = $request->validated('author');

            $query = User::with('article')->where('firstName','like','%'.$author.'%')->get();
            
        }

        if($query->isEmpty()){
            return response()->json([
           
                'search' => 'Not result'
            ],404);
        }

       

        return response()->json([
           
            'search' => $query,
        ]);
    }
}
