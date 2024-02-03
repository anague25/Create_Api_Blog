<?php

namespace App\Http\Controllers\api\v1\admin;

use Exception;
use App\Models\User;
use App\Models\api\v1\Article;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\api\v1\admin\users\UserUpdateRequest;

class UsersController extends Controller
{

     //get all user 
    public function index()
    {
        try{

            if(Gate::denies('admin-action'))
            {
            return response()->json([
                'status' => 0,
                'message' => 'Permission denied'
            
            ],403);
            }


            $users = User::orderByDesc('created_at')->with('article','role')->get();
    
            return response()->json([
                'status' => '1',
                'users' => $users
            ],200);
        }
        catch(Exception $e)
        {
            return response()->json($e);
        }
    }


//get single user
public function show(User $user){
    try{

        if(Gate::denies('admin-action'))
        {
        return response()->json([
            'status' => 0,
            'message' => 'Permission denied'
        
        ],403);
        }


      $user = $user->with('article','role')->get();

        return response()->json([
            'status' => '1',
            'user' => $user
        ],200);
    }
    catch(Exception $e)
    {
        return response()->json($e);
    }
}

   //updade user
    public function update(UserUpdateRequest $request, User $user)
    {
        
        try {
            
            if(Gate::denies('admin-action'))
            {
            return response()->json([
                'status' => 0,
                'message' => 'Permission denied'
            
            ],403);
            }

            $userExist = User::where('id', $user->id)->exists();
            if ($userExist) {

                $data = $this->storeAndUpdateImage($request, $user,$folderNameImage='user');

                $updateUser = $user->update($data);
                $user->role()->sync($request->validated('role'));


                return response()->json([
                    'status' => 1,
                    'status_message' => 'Successfully updated user',
                    'user' => $user
                ], 200);
            } else {
                return response()->json([
                    'status' => 0,
                    'status_message' => 'User not found',
                ], 404);
            }
        } catch (Exception $e) {

            return response()->json($e);
        }





    }

    /**
     * admin can delete user
     */
    public function destroy($user)
    {
        try{

            if(Gate::denies('admin-action'))
            {
            return response()->json([
                'status' => 0,
                'message' => 'Permission denied'
            
            ],403);
            }
          


            $user = User::find($user);

            if(!$user){
                return response()->json([
                    'status' => 0,
                    'status_message' => 'User not found',
                ], 404);
            }
    
    
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
    
            $posts = Article::where('user_id',$user->id)->get();
    
            //    $posts->delete();
            foreach($posts as $post){
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
    
                $post->category()->dissociate();
                $post->save();
                $post->comment()->delete();
                $post->like()->delete();
                $post->tag()->sync([]);
                $post->delete();
            }
    
          
            $user->article()->delete();
            $user->category()->delete();
            $user->comment()->delete();
            $user->like()->delete();
            $user->tag()->delete();
            $user->role()->sync([]);
            $user->delete();
    
            return response()->json([
                'status' => 1,
                'status_message' => 'User deleted successfully',
            ], 200);
           

           
        }
        catch(Exception $e)
        {
            return response()->json($e);
        }
    }
}
