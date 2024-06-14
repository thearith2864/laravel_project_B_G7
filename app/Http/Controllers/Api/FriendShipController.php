<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendShipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $friends = $user->friends;

        return $friends;
    }

    public function destroy($friendId)
    {
        $user = Auth::user();
        $friend = User::find($friendId);
        // $user->removeFriend($friend);

        return redirect()->route('friends.index')->with('success', 'Friend removed successfully.');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $friend = User::findOrFail($request->friend_id);
        // $user->addFriend($friend);

        return redirect()->route('friends.index')->with('success', 'Friend added successfully.');
    }

}
