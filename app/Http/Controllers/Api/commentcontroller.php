<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        Comment::updateComment($request, $id);
        return ["success" => true, "Message" =>"comment updated successfully"];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Comment::deleteComment($id);
        return ["success" => true, "Message" =>"comment deleted successfully"];
    }
}
