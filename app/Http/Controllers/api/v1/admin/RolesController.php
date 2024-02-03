<?php

namespace App\Http\Controllers\api\v1\admin;

use Exception;
use App\Models\api\v1\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class RolesController extends Controller
{
    /**
     * //get all roles 
     */
    public function index()
    {
        try
        {
            if(Gate::denies('admin-action'))
            {
            return response()->json([
                'status' => 0,
                'message' => 'Permission denied'
            
            ],403);
            }


            return response()->json(
                [
                    'status' => 1,
                    'role' => Role::all()
                ],200);
            

        }
        catch(Exception $e)
        {
            return response()->json($e);
        }

    }


  
  

    /**
     * delete role
     */
    public function destroy(Role $role)
    {
        try{
           
            if(!$role){
                return response()->json([
                    'status' => 0,
                    'message' => 'tag not found'
                ],404);
            }
            
            
            $role->user()->sync([]);
            $role->delete();
    
            return response()->json([
                'status' => 1,
                'message' => 'role deleted.'
            ],200);
        }
        catch(Exception $e)
        {
            return response()->json($e);
        }
    }
}
