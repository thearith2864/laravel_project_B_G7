<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LispostResource;
use App\Models\Media;
use App\Models\Post;
use Illuminate\Http\Request;

class postcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $this->params = $request->only('search');
        $post = Post::list($this->params);
        $post = LispostResource::collection($post);
        return response(['success' => true, 'data' =>$post], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $media = null;
        $mediaId = null;
        if ($request->hasFile('image')) {
            // Store the uploaded image using your Media model or service
            $media = Media::store($request);
            $mediaId = $media->id;
        }
        Post::store($request, null, $mediaId);
        return ["success" => true, "Message" =>"Post created successfully"];
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
