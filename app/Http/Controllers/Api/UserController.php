<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Post(
     *     path="/api/user/register",
     *     tags={"Register"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="c_password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="accessToken", type="string")
     *         )
     *     )
     * )
     */

        public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'name' => 'required|string|max:30',
                'email' => 'required|string|email|max:50|unique:users',
                'password' => 'required|string|min:8'
                
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validateUser->errors()
                ], 400);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'data' => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function listRigisterUsers()
    {
        $users = User::all();
        return response()->json([
            'users' => $users
        ], 200);
    }
/** 
     * @OA\Post(
     *     path="/api/user/login",
     *     tags={"Login"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="accessToken", type="string")
     *         )
     *     )
     * )
     */
   

    // user login function
    public function userLogin(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validateUser->errors()
                ], 400);
            }
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email or password is incorrect'
                ], 401);
            }
            $user = User::where('email', $request->email)->first();
            return response()->json([
                'status' => true,
                'data' => $user,
                'message' => 'User logged in successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function listLoginUsers()
    {
        $users = User::all();
        return response()->json([
            'users' => $users
        ], 200);
    }
    
    public function logout(Request $request)
    {
        
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
   
}
