<?php

namespace App\Http\Controllers;

use App\Models\ChatBox;
use Illuminate\Http\Request;

class ChatBoxController extends Controller
{
    function sendMessage()  {

        $chat = new ChatBox();
        $chat->crf_id = \Request::input('crf_id');
        $chat->sender_id = \Request::input('sender_id');
        $chat->messages = \Request::input('messages');
        $chat->message_time = \Request::input('message_time');
        $chat->save();
        
        return response()->json(['message'=>'Send Message successfully']);
    }

    public function getAllMessage()    {

        $chat = ChatBox::
        join('users','users.id','=','chat_box.sender_id')
        ->get();

        return response()->json(['chat' => $chat]);
    }

    public function getAllMessageByCrfId($criId)    {

        $chat = ChatBox::
        join('users','users.id','=','chat_box.sender_id')
        ->where('crf_id',$criId)
        ->get();

        return response()->json(['chat' => $chat]);
    }
}
