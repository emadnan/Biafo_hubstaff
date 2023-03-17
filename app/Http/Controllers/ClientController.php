<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    function add_client(){
        $client = new Client();
        $client->client_name = \Request::input('client_name');
        $client->project = \Request::input('project');
        $client->invoicing = \Request::input('invoicing');
        $client->project_status = \Request::input('project_status');
        $client->save();
        return response()->json(['message'=>'Add Client successfully']);
    }

    function update_client(){
        $id = \Request::input('id');
        $client = Client::where('id',$id)
        ->update([
            'client_name' => \Request::input('client_name'),
            'project' => \Request::input('project'),
            'invoicing' => \Request::input('invoicing'),
            'project_status' => \Request::input('project_status'),
        ]);

        return response()->json(['Message' => 'Client Updated']);
    }

    public function get_client()
    {
        $client = Client::get();
        return response()->json(['Departments' => $client]);
    }

    function delete_client(){
        $id = \Request::input('id');
        $client = Client::where('id',$id)->delete();

        return response()->json(['message'=>'delete Client successfully']);
    }

}
