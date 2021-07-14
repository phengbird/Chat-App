<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //
    public function rooms(Request $request) {
        return ChatRoom::all();
    }

    public function messages(Request $request,$roomId) {
        return ChatMessage::where('chat_room_id',$roomId)->with('user')->orderby('created_at','DESC')->get();
    }

    public function newMessages(Request $request,$roomId) {
        $newMessage = ChatMessage::create([
            'user_id'=>auth()->user()->id,
            'chat_room_id'=>$roomId,
            'message'=>$request->message
        ]);

        broadcast(new NewChatMessage($newMessage))->toOthers();
        
        return $newMessage;
    }
}
