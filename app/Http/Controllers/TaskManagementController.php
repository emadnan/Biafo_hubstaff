<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskManagement;

use Illuminate\Http\Request;

class TaskManagementController extends Controller
{
    public function addTasks(){
        
        $userId = Auth::id();

        $task = new TaskManagement();
        $task->user_id = \Request::input('user_id');
        $task->project_id = \Request::input('project_id');
        $task->task_description = \Request::input('task_description');
        $task->start_date = \Request::input('start_date');
        $task->dead_line = \Request::input('dead_line');
        $task->team_lead_id =$userId;

        $task->save();
        
        return response()->json(['message'=>'Add Task Successfully']);
    }

    function getTasks(){
        
        $task = TaskManagement::
        select('task_managements.*','users.*','projects.*','task_managements.id as task_managements_id')
        ->join('users','users.id','=','task_managements.user_id')
        ->join('projects','projects.id','=','task_managements.project_id')
        ->with('team_lead_details')
        ->get();

        return response()->json(['task'=>$task]);
    }

    function getTaskById($id){
        $task = TaskManagement::
        select('task_managements.*','users.*','projects.*','task_managements.id as task_managements_id')
        ->join('users','users.id','=','task_managements.user_id')
        ->join('projects','projects.id','=','task_managements.project_id')
        ->where('task_managements_id',$id)
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
            'dead_line' => \Request::input('dead_line')
        ]);
        
        return response()->json(['message'=>'Update Tasks Successfully']);
    }

    function deleteTaskById(){
        
        $id = \Request::input('id');
        $task = TaskManagement::

        where('id',$id)
        ->delete();

        return response()->json(['task'=>'delete fsf Successfully']);
    }
}
