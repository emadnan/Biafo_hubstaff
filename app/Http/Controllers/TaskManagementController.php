<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskManagement;
use Illuminate\Support\Facades\Mail;
use App\Mail\AssignTaskEmail;


use Illuminate\Http\Request;

class TaskManagementController extends Controller
{
    public function addTasks()  {
        
        $userId = Auth::id();

        $task = new TaskManagement();
        $task->user_id = \Request::input('user_id');
        $task->project_id = \Request::input('project_id');
        $task->task_description = \Request::input('task_description');
        $task->start_date = \Request::input('start_date');
        $task->dead_line = \Request::input('dead_line');
        $task->priorites = \Request::input('priorites');
        $task->team_lead_id = $userId;

        $screenShots = \Request::input('attachment');

            if (!empty($screenShots)) {
                $image = str_replace('data:image/png;base64,', '', $screenShots);
                $image = str_replace(' ', '+', $image);
                $imageName = uniqid() . '.' . 'png';
                \File::put(public_path() . '/development_logics/' . $imageName, base64_decode($image));
                $task->attachments = $imageName;

            }

        $latestTM = TaskManagement::where('project_id',$task->project_id)->where('user_id',$task->user_id)->orderBy('ticket_no', 'desc')->first();

        if ($latestTM) {
            $task->ticket_no = $latestTM->ticket_no + 1;
        } else {
            $task->ticket_no = 1;
        }

        $task->save();
        
        $task1 = TaskManagement::
            select('task_managements.*', 'users.name as user_name','users.email as user_email', 'projects.project_name','users.id as users_id','projects.id as projects_id')
            ->join('users', 'users.id', '=', 'task_managements.user_id')
            ->join('projects', 'projects.id', '=', 'task_managements.project_id')
            ->where('task_managements.id', $task->id)
            ->with('team_lead_details')
            ->first();
        // print_r($task1);
        // exit();
        $mailData = [
            'userName' => $task1->user_name,
            'projectName' => $task1->project_name,
            'deadline' => $task1->dead_line,
            'email' => $task1->user_email,
            'priorities' => $task1->priorites,
            'taskDescription' => $task1->task_description,
            'teamLeadName' => $task1->team_lead_details->name,
            'teamLeadEmail' => $task1->team_lead_details->email
        ];
        
        // Send Email
        Mail::to($task1->user_email)->send(new AssignTaskEmail($mailData));

        return response()->json(['message' => 'Task added successfully']);
    }


    function getTasks(){
        
        $task = TaskManagement::
        select('task_managements.*','users.*','projects.*','task_managements.id as task_managements_id','task_managements.start_date as task_managements_start_date','task_managements.dead_line as task_managements_dead_line')
        ->join('users','users.id','=','task_managements.user_id')
        ->join('projects','projects.id','=','task_managements.project_id')
        ->with('team_lead_details')
        ->get();

        return response()->json(['task'=>$task]);
    }

    function getTaskById($id){
        $task = TaskManagement::
        select('task_managements.*','users.*','projects.*','task_managements.id as task_managements_id','task_managements.start_date as task_managements_start_date','task_managements.dead_line as task_managements_dead_line')
        ->join('users','users.id','=','task_managements.user_id')
        ->join('projects','projects.id','=','task_managements.project_id')
        ->where('task_managements.id',$id)
        ->with('team_lead_details')
        ->first();

        return response()->json(['task'=>$task]);
    }

    function updateTasks(){
        $id = \Request::input('id');
        $fsf_Assign_to_users = TaskManagement::where('id',$id)
        ->update([
            'user_id' => \Request::input('user_id'),
            'project_id' => \Request::input('project_id'),
            'team_lead_id' => \Request::input('team_lead_id'),
            'task_description' => \Request::input('task_description'),
            'start_date' => \Request::input('start_date'),
            'dead_line' => \Request::input('dead_line'),
            'status' => \Request::input('status'),
            'priorites' => \Request::input('priorities')
        ]);
        
        return response()->json(['message'=>'Update Tasks Successfully']);
    }

    function updateStatusByUserTask(){
 
        $id = \Request::input('id');

        $task = TaskManagement::where('id',$id)
        ->update([
            'status' => \Request::input('status'),
            'comment' => \Request::input('comment')
        ]);
        
        if($task->status=='Complete'){
            
            $task1 = TaskManagement::
            select('task_managements.*', 'users.name as user_name','users.email as user_email', 'projects.project_name','users.id as users_id','projects.id as projects_id')
            ->join('users', 'users.id', '=', 'task_managements.user_id')
            ->join('projects', 'projects.id', '=', 'task_managements.project_id')
            ->where('task_managements.id', $task->id)
            ->with('team_lead_details')
            ->first();
            // print_r($task1);
            // exit();
            $mailData = [
                'userName' => $task1->user_name,
                'projectName' => $task1->project_name,
                'deadline' => $task1->dead_line,
                'email' => $task1->user_email,
                'priorities' => $task1->priorites,
                'taskDescription' => $task1->task_description,
                'teamLeadName' => $task1->team_lead_details->name,
                'teamLeadEmail' => $task1->team_lead_details->email
            ];
            
            // Send Email
            Mail::to($task1->user_email)->send(new AssignTaskEmail($mailData));

        }

        return response()->json(['message'=>'Update Status and comment of task Successfully']);
    }

    function deleteTaskById(){
        
        $id = \Request::input('id');
        $task = TaskManagement::

        where('id',$id)
        ->delete();

        return response()->json(['task'=>'delete fsf Successfully']);
    }

    function getTaskByUserId($userId){
        $task = TaskManagement::
        select('task_managements.*','users.*','projects.*','task_managements.id as task_managements_id','task_managements.start_date as task_managements_start_date','task_managements.dead_line as task_managements_dead_line')
        ->join('users','users.id','=','task_managements.user_id')
        ->join('projects','projects.id','=','task_managements.project_id')
        ->where('user_id',$userId)
        ->with('team_lead_details')
        ->get();

        return response()->json(['task'=>$task]);
    }

    function getTaskByProjectId($projectId){
        $task = TaskManagement::
        select('task_managements.*','users.*','projects.*','task_managements.start_date as task_managements_start_date','task_managements.id as task_managements_id','task_managements.dead_line as task_managements_dead_line')
        ->join('users','users.id','=','task_managements.user_id')
        ->join('projects','projects.id','=','task_managements.project_id')
        ->where('project_id',$projectId)
        ->with('team_lead_details')
        ->get();

        return response()->json(['task'=>$task]);
    }

    function getTaskByUserIdAndProjectId($userId,$projectId){
        $task = TaskManagement::
        select('task_managements.*','users.*','projects.*','task_managements.start_date as task_managements_start_date','task_managements.id as task_managements_id','task_managements.dead_line as task_managements_dead_line')
        ->join('users','users.id','=','task_managements.user_id')
        ->join('projects','projects.id','=','task_managements.project_id')
        ->where('project_id',$projectId)
        ->where('user_id',$userId)
        ->with('team_lead_details')
        ->get();

        return response()->json(['task'=>$task]);
    }
}
