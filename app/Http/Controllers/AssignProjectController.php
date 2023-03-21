<?php

namespace App\Http\Controllers;
use App\Models\AssignProject;
use Illuminate\Http\Request;

class AssignProjectController extends Controller
{
    public function assign_projects(Request $request){
        $project_id = $request->project_id;
        $start_date = $request->start_date;
        $dead_line = $request->dead_line;
        $user_ids = $request->user_ids;
        foreach($user_ids as $user_id)
        {
            $assign = new AssignProject;
            $assign->project_id = $project_id;
            $assign->user_id = $user_id;
            $assign->start_date = $start_date;
            $assign->dead_line = $dead_line;
            $assign->save();
        }
        return response()->json(['message'=>'Assign Projects Successfully']);
    }

    public function get_assign_projects()
    {
        $assign = AssignProject::select('users.*','users.id as user_id','projects.*','projects.id as project_id')
        ->join('users','users.id','=','assign_projects.user_id')
        ->join('projects','projects.id','=','assign_projects.project_id')
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
        $start_date = $request->start_date;
        $dead_line = $request->dead_line;
        $user_ids = $request->user_ids;
        $Project_id = \Request::input('project_id');
        $assign = AssignProject::where('Project_id',$Project_id)->delete();
        foreach($user_ids as $user_id)
        {
            $assign = new AssignProject;
            $assign->project_id = $project_id;
            $assign->user_id = $user_id;
            $assign->start_date = $start_date;
            $assign->dead_line = $dead_line;
            $assign->save();
        }

        return response()->json(['message'=>'Update Assign Projects Successfully']);
    }
}
