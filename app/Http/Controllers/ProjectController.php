<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\ProjectScreenshots;
use App\Models\AssignProject;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProjectController extends Controller
{

    function add_project()  {

        $project = new Project();
        $project->department_id = \Request::input('department_id');
        $project->company_id = \Request::input('company_id');
        $project->project_name = \Request::input('project_name');
        $project->description = \Request::input('description');
        $project->start_date = \Request::input('start_date');
        $project->dead_line = \Request::input('dead_line');
        $project->team_id = \Request::input('team_id');
        $project->to_dos = \Request::input('to_dos');
        $project->budget = \Request::input('budget');
        $project->save();
        
        return response()->json(['message' => 'Add Project successfully']);
    }

    function calculateTimeDifferenceInHours($startDate, $endDate)   {

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $difference = $end->diffInHours($start);
        
        return $difference;
    }


    function update_project()   {

        $id = \Request::input('id');
        $project = Project::where('id',$id)
        ->update([
            'department_id' => \Request::input('department_id'),
            'company_id' => \Request::input('company_id'),
            'project_name' => \Request::input('project_name'),
            'description' => \Request::input('description'),
            'budget' => \Request::input('budget'),
            'team_id' => \Request::input('team_id'),
            'to_dos' => \Request::input('to_dos'),
            'start_date' => \Request::input('start_date'),
            'dead_line' => \Request::input('dead_line')
        ]);

        return response()->json(['Message' => 'Project Updated']);
    }

    public function get_projects()  {

        $project = Project::select('company.*','departments.*','projects.*','projects.id as project_id','projects.description as project_description')->
        join('company','company.id','=','projects.company_id')
        ->join('departments','departments.id','=','projects.department_id')
        ->get();
        return response()->json(['projects' => $project]);
    }

    function delete_project()   {
        $id = \Request::input('id');
        $project = Project::where('id',$id)->delete();

        return response()->json(['message'=>'delete Project successfully']);
    }

    public function get_project_by_project_id($project_id)  {
        
        $project = Project::select('projects.*','projects.id as project_id','projects.description as project_description','company.*','departments.*')
        ->join('company','company.id','=','projects.company_id')
        ->join('departments','departments.id','=','projects.department_id')
        ->where('projects.id',$project_id)
        ->get();
        
        return response()->json(['projects' => $project]);
    }

    public function get_project_by_user_id($user_id)    {

        $project = AssignProject::select('assign_projects.*','assign_projects.project_id as assign_projects_project_id','projects.*','projects.id as project_id','streams.*','streams.user_id as streams_user_id','streams.project_id as streams_project_id')
        ->join('projects','projects.id','=','assign_projects.project_id')
        ->join('streams','streams.id','=','assign_projects.stream_id') 
        ->where('assign_projects.user_id',$user_id)
        ->get();
        
        return response()->json(['projects' => $project]);
    }

    public function sum($project_id)    {

        $hours = ProjectScreenshots::where('project_id', $project_id)->sum('hours');
        $minutes = ProjectScreenshots::where('project_id', $project_id)->sum('minutes');
        $seconds = ProjectScreenshots::where('project_id', $project_id)->sum('seconds');
        if($seconds>60){
            $seconds = $seconds - 60;
            $minutes = $minutes + 1;
        }

        if($minutes>60){
            $minutes = $minutes - 60;
            $hours = $hours + 1;
        }

        $project = Project::select('projescts.*','projects.house_time')
        ->where('id',$project_id)
        ->get();
        
        $data = compact('hours', 'minutes', 'seconds');
        return response()->json($data);
    }
}
