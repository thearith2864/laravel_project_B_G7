<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LispostResource;
use App\Models\Media;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    /** 
    * @OA\Post(
        *     path="/api/add-Post",
        *     tags={"add post"},
        *     summary="post a new user",
        *     @OA\RequestBody(
        *         @OA\JsonContent(
        *             type="object",
        *             @OA\Property(property="title", type="string"),
        *             @OA\Property(property="image", type="file"),
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
    public function addPost(Request $request)
    {
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
        $post = Post::find($id);
        if (  Auth()-> user() -> id  == $post-> user_id){

            Post::edit($request, $id);
            return ["success" => true, "Message" =>"Post updated successfully"];
        }else{
            return ["success" => false, "Message" =>"You are not allowed to update this post"];
        }
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $post = Post::find($id);
        if (  Auth()-> user() -> id  == $post-> user_id){
        Post::destroy($id);
        return ["success" => true, "Message" =>"Post deleted successfully"];
        }else{
            return ["success" => false, "Message" =>"You are not allowed to delete this post"];
        }
    }
}
