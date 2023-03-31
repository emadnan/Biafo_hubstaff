<?php

namespace App\Http\Controllers;
use App\Models\AssignProject;
use Illuminate\Http\Request;

class AssignProjectController extends Controller
{
    public function assign_projects(Request $request){
        $project_id = $request->project_id;
        $stream_id = $request->stream_id;
        $user_ids = $request->user_ids;
        foreach($user_ids as $user_id)
        {
            $assign = new AssignProject;
            $assign->project_id = $project_id;
            $assign->stream_id = $stream_id;
            $assign->user_id = $user_id;
            $assign->save();
        }
        return response()->json(['message'=>'Assign Projects Successfully']);
    }

    public function get_assign_projects()
    {
        $assign = AssignProject::select('users.*','users.id as user_id','projects.*','projects.id as project_id', 'streams.*','streams.id as stream_id')
        ->join('users','users.id','=','assign_projects.user_id')
        ->join('projects','projects.id','=','assign_projects.project_id')
        ->join('streams','streams.id','=','assign_projects.stream_id')
        ->get();
        return response()->json(['Project_Assigns' => $assign]);
    }

    function delete_assign_projects(){
        $Project_id = \Request::input('project_id');
        $assign = AssignProject::where('Project_id',$Project_id)->delete();

        return response()->json(['message'=>'delete Assign Projects successfully']);
    }

    public function update_assign_projects(Request $request){
        
        $project_id = $request->project_id;
        $user_ids = $request->user_ids;
        $Project_id = \Request::input('project_id');
        $assign = AssignProject::where('Project_id',$Project_id)->delete();
        foreach($user_ids as $user_id)
        {
            $assign = new AssignProject;
            $assign->project_id = $project_id;
            $assign->user_id = $user_id;
            $assign->save();
        }

        return response()->json(['message'=>'Update Assign Projects Successfully']);
    }

    public function get_assign_project_by_id($id){
        
        $assign = AssignProject::where('project_id',$id)->get();

        return response()->json(['Assigns' => $assign]);
    }
}
