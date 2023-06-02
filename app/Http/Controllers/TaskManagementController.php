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
            with('getFsfParameter')
            ->get();

        return response()->json(['task'=>$task]);
    }

}
