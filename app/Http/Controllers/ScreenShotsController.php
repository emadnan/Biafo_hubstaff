<?php

namespace App\Http\Controllers;
use App\Models\ScreenShot;
use Illuminate\Http\Request;

class ScreenShotsController extends Controller
{
    function add_screen_shots(){
        $ScreenShot = new ScreenShot();
        $ScreenShot->user_id = \Request::input('user_id');
        $ScreenShot->company_id = \Request::input('company_id');
        $ScreenShot->department_id = \Request::input('department_id');
        $ScreenShot->project_id = \Request::input('project_id');
        $ScreenShot->attechment_path = \Request::input('attechment_path');
        $ScreenShot->start_time = \Request::input('start_time');
        $ScreenShot->updated_time = \Request::input('updated_time');
        $ScreenShot->end_time = \Request::input('end_time');
        $ScreenShot->save();
        return response()->json(['message'=>'Add screen shot successfully']);
    }
}
