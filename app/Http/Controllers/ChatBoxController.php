<?php

namespace App\Http\Controllers;

use App\Models\ChatBox;
use App\Models\ChatBoxFsf;
use App\Models\ChatBoxFsfToUser;
use App\Models\ChatBoxForTask;
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
        with('crfChatSenderDetailes')
        ->get();

        return response()->json(['chat' => $chat]);
    }

    public function getAllMessageByCrfId($criId)    {

        $chat = ChatBox::
        where('crf_id',$criId)
        ->with('crfChatSenderDetailes')
        ->get();

        return response()->json(['chat' => $chat]);
    }

    function sendFsfMessage()  {
        
        // Assuming you have imported the necessary classes here.
    
        $chat = new ChatBoxFsf();
        $chat->fsf_id = \Request::input('fsf_id');
        $chat->sender_id = \Request::input('sender_id');
        $chat->messages = \Request::input('messages');
        
        // Get the current date and time in the desired format (using Carbon).
        $message_time = Carbon::now()->format('Y-m-d H:i:s');
        $chat->message_time = $message_time;

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
        join('users','usres.id','=','chat_box_fsf.sender_id')
        ->where('fsf_id',$fafId)
        ->get();

        return response()->json(['chat' => $chat]);
    }


    function sendFsfToEmploeeMessage()  {
        
        // Assuming you have imported the necessary classes here.
    
        $chat = new ChatBoxFsfToUser();
        $chat->fsf_id = \Request::input('fsf_id');
        $chat->sender_id = \Request::input('sender_id');
        $chat->messages = \Request::input('messages');
        
        // Get the current date and time in the desired format (using Carbon).
        $message_time = Carbon::now()->format('Y-m-d H:i:s');
        $chat->message_time = $message_time;
        
        $chat->save();
    
        return response()->json(['message' => 'Send Message successfully']);
    }

    public function getAllFsfToEmploeeMessage()    {

        $chat = ChatBoxFsfToUser::
        with('crfChatSenderDetailes')
        ->get();

        return response()->json(['chat' => $chat]);
    }

    public function getAllMessageToEmploeeByFsfId($fafId)    {

        $chat = ChatBoxFsfToUser::
        where('fsf_id',$fafId)
        ->with('crfChatSenderDetailes')
        ->get();

        return response()->json(['chat' => $chat]);
    }

    function sendTaskMessagetoEmployee()  {
        
        // Assuming you have imported the necessary classes here.
    
        $chat = new ChatBoxForTask();
        $chat->crf_id = \Request::input('crf_id');
        $chat->sender_id = \Request::input('sender_id');
        $chat->messages = \Request::input('messages');
        
        // Get the current date and time in the desired format (using Carbon).
        $message_time = Carbon::now()->format('Y-m-d H:i:s');
        $chat->message_time = $message_time;
        
        $chat->save();
    
        return response()->json(['message' => 'Send Message successfully']);
    }

    public function getAllTaskMessageOfEmployee()    {

        $chat = ChatBoxForTask::
        with('crfChatSenderDetailes')
        ->get();

        return response()->json(['chat' => $chat]);
    }

    public function getTaskMessageFromEmployeeByFsfId($criId)    {

        $chat = ChatBoxForTask::
        where('crf_id',$criId)
        ->with('crfChatSenderDetailes')
        ->get();

        return response()->json(['chat' => $chat]);
    }
}
