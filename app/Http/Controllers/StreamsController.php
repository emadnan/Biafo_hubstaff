<?php

namespace App\Http\Controllers;
use App\Models\Streams;
use Illuminate\Http\Request;

class StreamsController extends Controller
{
    function addStreams()  {

        $stream = new Streams();
        $stream->company_id = \Request::input('company_id');
        $stream->stream_name = \Request::input('stream_name');
        $stream->save();
        return response()->json(['message'=>'Add stream successfully']);

    }

    function updateStream() {

        $id = \Request::input('id');
        $stream = Streams::where('id',$id)
        ->update([
            'company_id' => \Request::input('company_id'),
            'stream_name' => \Request::input('stream_name'),
        ]);

        return response()->json(['Message' => 'stream Updated']);
    }

    function deleteStream()    {

        $id = \Request::input('id');
        $stream = Streams::where('id',$id)->delete();

        return response()->json(['message'=>'delete stream successfully']);
    }

    public function getStreamByCompanyId($id)  {

        $stream = Streams::where('company_id',$id)->get();
        return response()->json(['streams' => $stream]);
    }

    public function getStreamById($id)  {

        $stream = Streams::where('id',$id)->get();
        return response()->json(['streams' => $stream]);
    }

    public function getStreams()
    {
        $streams = Streams::get();
        return response()->json(['Streams' => $streams]);
    }
}
