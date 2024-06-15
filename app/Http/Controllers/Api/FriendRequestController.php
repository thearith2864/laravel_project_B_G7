<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FriendRequest;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class FriendRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $friends = FriendRequest::where(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
        })->where('status', 'accepted')->get();

        return response()->json($friends);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $friend = User::find($request->receiver_id);

        if ($friend) {
            FriendRequest::create([
                'sender_id' => $user->id,
                'receiver_id' => $request->receiver_id,
                'status' => 'pending',
            ]);
            return response()->json(['message' => 'Friend request sent successfully']);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $friendRequest = FriendRequest::find($id);

        if ($friendRequest && $friendRequest->receiver_id == Auth::id()) {
            $friendRequest->update(['status' => $request->status]);

            if ($request->status == 'accepted') {
                Friend::create([
                    'user_id1' => $friendRequest->sender_id,
                    'user_id2' => $friendRequest->receiver_id,
                ]);
            }

            return response()->json(['message' => 'Friend request updated successfully']);
        }

        return response()->json(['message' => 'Friend request not found or unauthorized'], 404);
    }

    public function destroy($id)
    {
        $friendRequest = FriendRequest::find($id);

        if ($friendRequest && ($friendRequest->sender_id == Auth::id() || $friendRequest->receiver_id == Auth::id())) {
            $friendRequest->delete();
            return response()->json(['message' => 'Friend request deleted successfully']);
        }

        return response()->json(['message' => 'Friend request not found or unauthorized'], 404);
    }
    public function friendsList()
    {
        $user = Auth::user();
        $friends = Friend::where('user_id1', $user->id)
                         ->orWhere('user_id2', $user->id)
                         ->get();

        $friendDetails = $friends->map(function ($friend) use ($user) {
            $friendId = $friend->user_id1 == $user->id ? $friend->user_id2 : $friend->user_id1;
            return User::find($friendId);
        });

        return response()->json($friendDetails);
    }
}
