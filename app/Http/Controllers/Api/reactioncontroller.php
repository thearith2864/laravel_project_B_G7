<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        Reaction::updateReaction($request, $id);
        return ["success" => true, "Message" =>"React updated successfully"];
    }

    public function destroy(string $id)
    {
        //
        Reaction::destroyReaction($id);
        return ["success" => true, "Message" =>"React deleted successfully"];
    }
}
