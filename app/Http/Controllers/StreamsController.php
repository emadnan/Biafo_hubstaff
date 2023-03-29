<?php

namespace App\Http\Controllers;
use App\Models\Streams;
use Illuminate\Http\Request;

class StreamsController extends Controller
{
    public function get_streams()
    {
        $streams = Streams::get();
        return response()->json(['Streams' => $streams]);
    }
}
