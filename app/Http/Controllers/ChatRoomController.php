<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ChatRoomResource;

class ChatRoomController extends Controller
{
    public function index(Request $request) {
        
        return inertia('Chat/Index', [
            'rooms' => ChatRoomResource::collection(ChatRoom::with('userOne')
                ->with('userTwo')
                ->myRooms()
                ->get()),
            'currentRoom' => $request->currentRoom ? ChatRoom::where('id', $request->currentRoom)->get() : []
        ]);
    }

    public function show(Request $request) {
        $routeOne = ChatRoom::where('user_one_id', Auth::id())->where('user_two_id', $request->userId)->first();
        $routeTwo = ChatRoom::where('user_one_id', $request->userId)->where('user_two_id', Auth::id())->first();

        if($routeOne) {
            return to_route('chat.room.index', [
                'currentRoom' => $routeOne
            ]);
        } else if($routeTwo) {
            return to_route('chat.room.index', [
                'currentRoom' => $routeTwo
            ]);
        } else {
            ChatRoom::create([
                'user_one_id' => Auth::id(),
                'user_two_id' => $request->userId,
            ]);

            return to_route('chat.room.index', [
                'currentRoom' => $routeOne
            ]);
        }
    }
}
