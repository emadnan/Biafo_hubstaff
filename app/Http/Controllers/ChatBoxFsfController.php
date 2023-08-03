<?php

namespace App\Http\Controllers;

use App\Models\ChatBoxFsf;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ChatBoxFsfController extends Controller
{
    function sendFsfMessage()  {
        
        // Assuming you have imported the necessary classes here.
    
        $chat = new ChatBoxFsf();
        $chat->fsf_id = \Request::input('fsf_id');
        $chat->sender_id = \Request::input('sender_id');
        $chat->messages = \Request::input('messages');
        
        $chat->save();
    
        return response()->json(['message' => 'Send Message successfully']);
    }

    public function getAllFsfMessage()    {

        $chat = ChatBoxFsf::
        with('crfChatSenderDetailes')
        ->get();

        return response()->json(['chat' => $chat]);
    }

    public function getAllMessageByFsfId($fafId)    {

        $chat = ChatBoxFsf::
        where('fsf_id',$fafId)
        ->with('crfChatSenderDetailes')
        ->get();

        return response()->json(['chat' => $chat]);
    }
}
