<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Media;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();
        return response()->json(['status' => true, 'data' => ProfileResource::collection($profiles)], 200);
    }

    public function uploadImage(Request $request)
    {
        $user = auth()->user(); 
        if ($user) {
            if ($request->hasFile('image')) {
                if($user){
                    $media = Media::store($request);
                    $mediaId = $media->image; 
                    return response()->json([
                        'success' => true,
                        'message' => 'Image uploaded successfully',
                        'media_id' => $mediaId,
                    ], 200);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No image uploaded',
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }

    }
    
    public function show(){
        $user = auth()->user(); 
        
        if($user){
            return response()->json(['status' => true, 'data' => new ProfileResource($user)], 200);
        }
        return response()->json(['status' => false, 'message' => 'User not found'], 404);
    }
    public function update(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'required|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Handle image upload
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = $file->storeAs('public/images', $filename);
            $validatedData['image'] = Storage::url($path);
        }
        return response()->json(['status' => true, 'message' => 'Profile updated successfully', 'data' => $user], 200);
    }
}
