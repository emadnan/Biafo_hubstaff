<?php

namespace App\Http\Controllers;
use App\Models\Streams;
use App\Models\StreamsHasUser;
use Illuminate\Http\Request;

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

    public function assignStreams(Request $request) {
        $stream_id = $request->stream_id;
        $assignments = [];
        // $request = json_decode(request()->getContent(), true);
        print_r($request->all());
        exit;
        StreamsHasUser::where('user_id', $request->user_id)
        ->where('stream_id', $request->stream_id)
        ->delete();

        foreach ($request->assignments as $key => $value) {
            $user_id = $value['user_id'];
            $assigning_type = $value['assigning_type'];
    
            $assign = new StreamsHasUser;
            $assign->assigning_type = $assigning_type;
            $assign->stream_id = $stream_id;
            $assign->user_id = $user_id;
            $assign->save();
    
            $assignments[] = [
                'user_id' => $user_id,
                'assigning_type' => $assigning_type,
            ];
        }
    
        return response()->json(['message' => 'Assign Streams Successfully', 'assignments' => $assignments]);
    }    
    
}
