<?php

namespace App\Http\Controllers;
use App\Models\streams;
use Illuminate\Http\Request;

class StreamsController extends Controller
{
    public function get_streams()
    {
        $streams = streams::get();
        return response()->json(['Streams' => $streams]);
    }
}
