<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShowUserNametPostedResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class commentcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Comment::store($request);
        return ["success" => true, "Message" =>"comment created successfully"];
    }


    public function update(Request $request, string $id)
    {
        //
        $comment = Comment::find($id);
        if (  Auth()-> user() -> id  == $comment-> user_id){
        Comment::updateComment($request, $id);
        return ["success" => true, "Message" =>"comment updated successfully", "User_Comment" => new ShowUserNametPostedResource($comment), "User_Reaction" => Auth()-> user() -> name];
        }else{
            return ["success" => false, "Message" =>"you are not allowed to update this comment" , "User_Comment" => new ShowUserNametPostedResource($comment), "User_update_Reaction" => Auth()-> user() -> name];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $comment = Comment::find($id);
        if (  Auth()-> user() -> id  == $comment-> user_id){
        Comment::deleteComment($id);
        return ["success" => true, "Message" =>"comment deleted successfully", "User_Commenat" => new ShowUserNametPostedResource($comment), "User_Reaction" => Auth()-> user() -> name];
        }else{
            return ["success" => false, "Message" =>"you are not allowed to delete this comment" , "User_Comment" => new ShowUserNametPostedResource($comment), "User_update_Reaction" => Auth()-> user() -> name];
    
    }}
}
