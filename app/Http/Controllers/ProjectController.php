<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    function add_project(){
        $project = new Project();
        $project->user_id = \Request::input('user_id');
        $project->department_id = \Request::input('department_id');
        $project->company_id = \Request::input('company_id');
        $project->project_name = \Request::input('project_name');
        $project->start_date = \Request::input('start_date');
        $project->dead_line = \Request::input('dead_line');
        $project->team_id = \Request::input('team_id');
        $project->to_dos = \Request::input('to_dos');
        $project->budget = \Request::input('budget');
        $project->save();
        return response()->json(['message'=>'Add Project successfully']);
    }

    function update_project(){
        $id = \Request::input('id');
        $project = Project::where('id',$id)
        ->update([
            'user_id' => \Request::input('user_id'),
            'department_id' => \Request::input('department_id'),
            'company_id' => \Request::input('company_id'),
            'project_name' => \Request::input('project_name'),
            'budget' => \Request::input('budget'),
            'team_id' => \Request::input('team_id'),
            'to_dos' => \Request::input('to_dos'),
            'start_date' => \Request::input('start_date'),
            'dead_line' => \Request::input('dead_line')
        ]);

        return response()->json(['Message' => 'Project Updated']);
    }

    public function get_projects()
    {
        $project = Project::join('company','company.id','=','projects.company_id')
        ->join('departments','departments.id','=','projects.department_id')
        ->join('users','users.project_id','=','projects.id')
        ->get();
        return response()->json(['projects' => $project]);
    }

    function delete_project(){
        $id = \Request::input('id');
        $project = Project::where('id',$id)->delete();

        return response()->json(['message'=>'delete Project successfully']);
    }

    public function get_project_by_user_id($id){
        
        $project = Project::where('user_id',$id)->get();
        return response()->json(['projects' => $project]);
    }
}
