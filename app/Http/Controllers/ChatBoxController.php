<?php

namespace App\Http\Controllers;

use App\Models\ChatBox;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ChatBoxController extends Controller
{
    function sendMessage()  {
        
        // Assuming you have imported the necessary classes here.
    
        $chat = new ChatBox();
        $chat->crf_id = \Request::input('crf_id');
        $chat->sender_id = \Request::input('sender_id');
        $chat->messages = \Request::input('messages');
        
        // Get the current date and time in the desired format (using Carbon).
        $message_time = Carbon::now()->format('Y-m-d H:i:s');
        $chat->message_time = $message_time;
        
        $chat->save();
    
        return response()->json(['message' => 'Send Message successfully']);
    }
    
    
    
    

    public function getAllMessage()    {

        $chat = ChatBox::
        join('users','users.id','=','chat_box_crf.sender_id')
        ->get();

        return response()->json(['chat' => $chat]);
    }

    public function getAllMessageByCrfId($criId)    {

        $chat = ChatBox::
        join('users','users.id','=','chat_box_crf.sender_id')
        ->where('crf_id',$criId)
        ->get();

        return response()->json(['chat' => $chat]);
    }
}
