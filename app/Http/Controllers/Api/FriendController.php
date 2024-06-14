<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FriendResource;
use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $friend = Friend::list();
        $friends = FriendResource::collection($friend);
        return response()->json(['status' => true, 'data' => $friends], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        friend::store($request);
        return response()->json(['status' => true, 'message' =>"friend created successfully"], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $friend = friend::find($id);
        $friends = new FriendResource($friend);
        return response()->json(['status' => true, 'data' => $friends], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        friend::store($request, $id);
        return response()->json(['status' => true, 'message' =>"friend updated successfully"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        friend::destroy($id);
        return response()->json(['status' => true, 'message' =>"friend deleted successfully"], 200);
    }
}
