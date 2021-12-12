<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function rooms(Request $request)
    {
        return ChatRoom::all();
    }
    public function messages(Request $request, $roomId)
    {
        return ChatMessage::where('chat_room_id', $roomId)->with('user')->latest()->get();
    }
    public function newMessage(Request $request, $roomId)
    {

        // DB::table('chat_messages')->insert(['chat_room_id' => $roomId, 'user_id' => 3, 'message' => $request->message]);
        $request->validate(['message' =>
        'required']);
        $msg = ChatMessage::create([
            'user_id' => auth()->user()->id,
            'chat_room_id' => $roomId,
            'message' => $request->message,
        ]);
        broadcast(new NewChatMessage($msg->chat_room_id))->toOthers();


        return 1;
    }
}
