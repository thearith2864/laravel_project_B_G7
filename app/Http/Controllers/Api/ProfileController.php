<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\ShowProfileResource;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Profile = Profile::list();
        $Profiles = ProfileResource::collection($Profile);
        return response()->json(['status' => true, 'data' => $Profiles], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Profile::store($request);
        return response()->json(['status' => true, 'message' =>"profile created successfully"], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Profile = Profile::find($id);
        $Profile = new ShowProfileResource($Profile);
        return response()->json(['status' => true, 'data' => $Profile], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     Profile::store($request, $id);
    //     return response()->json(['status' => true, 'message' =>"profile updated successfully"], 200);
    // }
    public function update(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        try {
            // Validate the incoming request
            $validateProfile = Validator::make($request->all(), [
                'user_id' => 'required|inter',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'bio' => 'required|string|max:255',
            ]);
            if ($validateProfile->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validateProfile->errors()
                ], 400);
            }  
            $profile = $user->profile; 

            if (!$profile) {
                return response()->json([
                    'status' => false,
                    'message' => 'Profile not found'
                ], 404);
            }

            // Update the profile's fields
            $profile->user_id = $request->user_id;
            $profile->bio = $request->bio;

            // Save the updated profile
            $profile->save();

            return response()->json([
                'status' => true,
                'data' => $profile,
                'message' => 'Profile updated successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Profile::destroy($id);
        return response()->json(['status' => true, 'message' =>"profile deleted successfully"], 200);
    }
}
