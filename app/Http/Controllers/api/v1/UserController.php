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

class UserController extends Controller
{


     /**
     * register user
     */
    public function register(UserRegisterRequest $request)
    {
        try {

            $user = new User();

            $data = $this->storeAndUpdateImage($request, $user);
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

                $data = $this->storeAndUpdateImage($request, $user);

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
     * store or update image
     */
    public function storeAndUpdateImage($request, User $user)
    {

        $data = $request->validated();

        $image = $request->validated('image');
        if ($image == null || $image->getError()) {
            return $data;
        }

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $data['image'] = $image->store('user', 'public');
        return $data;
    }

    /**
     * get all user
     */
    public function index()
    {
        //
    }

    


    /**
     * get single user
     */
    public function user()
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
    public function destroy(string $id)
    {
        //
    }
}
