<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShowUserNametPostedResource;
use App\Models\Reaction;
use Illuminate\Http\Request;

class reactioncontroller extends Controller
{

    public function store(Request $request)
    {
        //
        Reaction::store($request);
        return ["success" => true, "Message" =>"React created successfully"];
    }

    public function update(Request $request, string $id)
    {
        //
        $post = Reaction::find($id);
        if (  Auth()-> user() -> id  == $post-> user_id){
        Reaction::updateReaction($request, $id);
        return ["success" => true, "Message" =>"React updated successfully" ,"User_Reaction" => new ShowUserNametPostedResource($post), "User_update_Reaction" => Auth()-> user() -> name];
        }else{
            return ["success" => false, "Message" =>"You are not the owner of this reaction","User_Reaction" => new ShowUserNametPostedResource($post), "User_update_Reaction" => Auth()-> user() -> name];
        }
    }

    public function destroy(string $id)
    {
        //
        $post = Reaction::find($id);
        if (  Auth()-> user() -> id  == $post-> user_id){
        Reaction::destroyReaction($id);
        return ["success" => true, "Message" =>"React deleted successfully"];
        }else{
            return ["success" => false, "Message" =>"You are not the owner of this reaction"];
    }
}
}
