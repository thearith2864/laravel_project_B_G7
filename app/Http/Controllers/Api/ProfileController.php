<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\ShowProfileResource;
use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Profile = Profile::list();
        $Profile = ProfileResource::collection($Profile);
        return response()->json(['status' => true, 'data' => $Profile], 200);
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
    public function update(Request $request, string $id)
    {
        Profile::store($request, $id);
        return response()->json(['status' => true, 'message' =>"profile updated successfully"], 200);
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
