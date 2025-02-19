<?php

namespace App\Http\Controllers;
use App\Models\AssignProject;
use Illuminate\Http\Request;

class AssignProjectController extends Controller
{
    public function assign_projects(Request $request){
        $AssignProject= AssignProject::where('project_id',$request->project_id)->where('stream_id',$request->stream_id)->delete();
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
        $assign = AssignProject::select('assign_projects.*','assign_projects.user_id as assign_projects_user_id','users.*','users.id as users_id','projects.*','projects.id as project_id', 'streams.*')
        ->join('users','users.id','=','assign_projects.user_id')
        ->join('projects','projects.id','=','assign_projects.project_id')
        ->join('streams','streams.id','=','assign_projects.stream_id')
        ->orderBy('projects.project_name', 'asc')
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

    public function get_assign_project_by_project_id($project_id, $stream_id){
        
        $assign = AssignProject::where('project_id',$project_id)
        ->where('stream_id',$stream_id)->get();

        return response()->json(['Assigns' => $assign]);
    }
}
