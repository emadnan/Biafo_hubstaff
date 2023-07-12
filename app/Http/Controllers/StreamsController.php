<?php

namespace App\Http\Controllers;
use App\Models\Streams;
use Illuminate\Http\Request;

class StreamsController extends Controller
{
    function add_permissions()  {

        $permission = new Streams();
        $permission->name = \Request::input('name');
        $permission->guard_name = 'APi11';
        $permission->save();
        return response()->json(['message'=>'Add Permission successfully']);

    }

    function updatepermission() {

        $id = \Request::input('id');
        $permission = Streams::where('id',$id)
        ->update([
            'name' => \Request::input('name'),
            'guard_name' => 'API'
        ]);

        return response()->json(['Message' => 'Permission Updated']);
    }

    function delete_permission()    {
        
        $id = \Request::input('id');
        $permission = Streams::where('id',$id)->delete();

        return response()->json(['message'=>'delete permission successfully']);
    }

    public function get_permissions_by_id($id)  {

        $permission = Streams::where('id',$id)->get();
        return response()->json(['permissions' => $permission]);
    }


    public function get_streams()
    {
        $streams = Streams::get();
        return response()->json(['Streams' => $streams]);
    }
}
