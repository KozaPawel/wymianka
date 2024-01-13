<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ChatMessageResource;

class ChatMessageController extends Controller
{
    public function index(Request $request) {
        return ChatMessageResource::collection(ChatMessage::where('chat_room_id', $request->roomId)
            ->orderBy('created_at', 'DESC')
            ->get());
    }

    public function store(Request $request) {
        $newMessage = ChatMessage::create([
            'user_id' => Auth::id(),
            'chat_room_id' => $request->roomId,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($newMessage))->toOthers();

        return $newMessage;
    }
}
