<?php

namespace App\Http\Controllers\api\v1;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\api\v1\user\UserLoginRequest;
use App\Http\Requests\api\v1\user\UserUpdateRequest;
use App\Http\Requests\api\v1\user\UserRegisterRequest;
use App\Models\api\v1\Article;

class UserController extends Controller
{


     /**
     * register user
     */
    public function register(UserRegisterRequest $request)
    {
        try {

            $user = new User();

            $data = $this->storeAndUpdateImage($request, $user,$folderNameImage='user');
            $data['password'] = Hash::make($request->validated('password'));


            $user = User::create($data);

            return response()->json([
                'status' => 1,
                'status_message' => 'Successfully registered user',
                'user' => $user,
            ],200);
        } catch (Exception $e) {

            return response()->json($e);
        }
    }



     /**
     * login user
     */
    public function login(UserLoginRequest $request)
    {
        try {

            $data = $request->validated();

            if (Auth::attempt($data)) {

                $user = Auth::user();
                $token = $user->createToken('MY_SECRET_KEY')->plainTextToken;


                return response()->json([
                    'status_code' => 1,
                    'status_message' => 'User logged',
                    'user' => $user,
                    'token' => $token

                ], 200);
            } else {
                return response()->json([
                    'status_code' => 0,
                    'status_message' => 'Invalid information',

                ], 403);
            }
        } catch (Exception $e) {

            return response()->json($e);
        }
    }



 /**
     * Update user.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {


            $userExist = User::where('id', $user->id)->exists();
            if ($userExist) {

                $data = $this->storeAndUpdateImage($request, $user,$folderNameImage='user');

                $updateUser = $user->update($data);

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
     * logout user
     */

     public function logout(Request $request){
       try{
        Auth::user()->tokens()->delete();
        return response()->json([
            'status' => 1,
            'status_message' => 'User disconnected Successfully',
        ], 200);
       }
       catch(Exception $e){
        return response()->json($e);
       }
     }



     

    /**
     * get all user
     */
    public function index()
    {
        try{
            return response()->json([
                'status' => '1',
                'users' => User::orderByDesc('created_at')->with('role')->get()
            ],200);
        }
        catch(Exception $e)
        {
            return response()->json($e);
        }
    }

    


    /**
     * get single user
     */
    public function show()
    {
        try{
            return response()->json([
                'status' => '1',
                'data' => Auth::user()
            ],200);
        }
        catch(Exception $e)
        {
            return response()->json($e);
        }
    }

   

    

    /**
     * delete user
     */
    public function destroy()
    {

        $user = User::find(auth()->user()->id);

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
}
