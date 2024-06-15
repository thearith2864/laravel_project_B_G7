<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = User::all();
        return response()->json(['status' => true, 'data' => ProfileResource::collection($profiles)], 200);
    }

    public function uploadImage(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max size example
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = $file->storeAs('public/images', $filename);

            return response()->json([
                'status' => true,
                'message' => 'Profile image uploaded successfully',
                'image_url' => Storage::url($path),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Image upload failed',
        ], 400);
    }
    public function show(){
        $user = auth()->user(); 
        $profile = $user->profile; 

        if (!$profile) {
            return response()->json(['status' => false,'message' => 'Profile not found'], 404);
        }

        return response()->json(['status' => true, 'data' => new ProfileResource($profile)], 200);
    }
    public function destroy($id)
    {
        $profile = User::destroyProfile($id);

        if (!$profile) {
            return response()->json(['status' => false, 'message' => 'Profile not found or already deleted'], 404);
        }

        return response()->json(['status' => true, 'message' => 'Profile deleted successfully', 'data' => new ProfileResource($profile)], 200);
    }
}
