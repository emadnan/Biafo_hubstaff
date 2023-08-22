<?php

namespace App\Http\Controllers;
use App\Models\Streams;
use App\Models\StreamsHasUser;
use Illuminate\Http\Request;
use DB;

class StreamsController extends Controller
{
    function addStreams()  {

        $stream = new Streams();
        $stream->company_id = \Request::input('company_id');
        $stream->stream_name = \Request::input('stream_name');
        $stream->project_id = \Request::input('project_id');
        $stream->start_time = \Request::input('start_time');
        $stream->end_time = \Request::input('end_time');


        $stream->save();
        return response()->json(['message'=>'Add stream successfully']);

    }

    function updateStream() {

        $id = \Request::input('id');
        $stream = Streams::where('id',$id)
        ->update([
            'company_id' => \Request::input('company_id'),
            'stream_name' => \Request::input('stream_name'),
            'project_id' => \Request::input('project_id'),
            'start_time' => \Request::input('start_time'),
            'end_time' => \Request::input('end_time')
        ]);

        return response()->json(['Message' => 'stream Updated']);
    }

    function deleteStream()    {

        $id = \Request::input('id');
        $stream = Streams::where('id',$id)->delete();

        return response()->json(['message'=>'delete stream successfully']);
    }

    public function getStreamByCompanyId($id)  {

        $stream = Streams::where('company_id',$id)
        ->with('projectDetails')
        ->get();
        return response()->json(['streams' => $stream]);
    }

    public function getStreamById($id)  {

        $stream = Streams::where('id',$id)
        ->with('projectDetails')
        ->get();
        return response()->json(['streams' => $stream]);
    }

    public function getStreams()
    {
        $streams = Streams::orderBy('stream_name', 'asc')
        ->with('projectDetails')
        ->get();
        return response()->json(['Streams' => $streams]);
    }

    public function assignStreamsToUsers(Request $request)   {

        $stream_id = $request->stream_id;
    $user_ids = $request->user_ids;

        if (is_string($user_ids)) {
            $user_ids = explode(',', $user_ids);
        }
        if ($user_ids === null) {

            // Handle the case when user_ids is null or not sent
            return response()->json(['message' => 'No user IDs provided'], 400);
        }
    
        $delete = StreamsHasUser::where('stream_id', $stream_id)->delete();
        
        foreach ($user_ids as $user_id) {

            $assign = new StreamsHasUser;
            $assign->stream_id = $stream_id;
            $assign->user_id = $user_id;
            $assign->save();
        }
    
        return response()->json(['message' => 'Assign streams to users Successfully']);
    }

    // public function assignStreamsTypes(Request $request) {

    //     $assign = new StreamsHasUser();
    //     $assign->stream_id = \Request::input('stream_id');
    //     $assign->user_id = \Request::input('user_id');
    //     $assign->assinging_type = \Request::input('assinging_type');
        
    //     $assingingtype = StreamsHasUser::where('user_id', $assign->userId)->sum('assinging_type');

    //     if(!($assingingtype))  {
             
    //         $assign->save();
    //     }
    //     elseif($assingingtype<3){

    //     }

        

    //     return response()->json(['message' => 'Assign streams to users Successfully']);
    // }
    public function assignStreamsTypes(Request $request) {

        $assign = new StreamsHasUser();
        $assign->stream_id = $request->input('stream_id');
        $assign->user_id = $request->input('user_id');
        $assign->assigning_type_id = $request->input('assigning_type_id');
        
        $user_id = $assign->user_id;
        $assigning_type_id = $assign->assinging_type_id;
    
        // Calculate the sum of assigning_type_id for the given user_id
        $totalAssigningTypeId = StreamsHasUser::where('user_id', $user_id)->sum('assigning_type_id');
    
        // Check if adding this assigning_type_id exceeds the limit
        if (($totalAssigningTypeId + $assigning_type_id) < 3) {
            // Check specific rules based on assigning_type value
            
            if ($assigning_type_id <= 3) {
                $allowedCount = 3; // Allow adding assinging_type_id when assigning_type is 1 or 2
                if ($totalAssigningTypeId + $assigning_type_id <= $allowedCount) {
                    $assign->save();
                    return response()->json(['message' => 'Assign streams to users successfully']);
                } else {
                    return response()->json(['message' => 'Your limit of assigning is about to end'], 422);
                }
            } else {
                return response()->json(['message' => 'Cannot assign streams to users'], 422);
            }
        } else {
            return response()->json(['message' => 'Your limit of assigning is about to end'], 422);
        }
    }
    

    function getUsersByStreamsId($streamId){
        $stream = StreamsHasUser::
        where('stream_id',$streamId)
        ->with('userDetails')
        ->get();

        return response()->json(['Streams' => $stream]);
    }
    
    function getAssigningStreamsUsers(){

        $stream = StreamsHasUser::get();

        return response()->json(['Streams' => $stream]);
    }
}
