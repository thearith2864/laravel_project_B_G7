<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function userLogout(Request $request){
        try{
            if (!$user = $request->user()) {
                return response()->json([
                    'status' => false,
                    'message' => 'User is not logout'
                ], 401);
            }
            $user->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'User logged out successfully'
            ], 200);
        }catch(\Throwable $th){
            return response()->json([
               'status' => false,
               'message' => $th->getMessage()
            ],500);
        }
    }
}
