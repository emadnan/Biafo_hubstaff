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

    function update_screen_shots(){
        $id = \Request::input('id');
        $ScreenShot = ScreenShot::where('id',$id)
        ->update([
            'user_id' => \Request::input('user_id'),
            'company_id' => \Request::input('company_id'),
            'department_id' => \Request::input('department_id'),
            'project_id' => \Request::input('project_id'),
            'attechment_path' => \Request::input('attechment_path'),
            'start_time' => \Request::input('start_time'),
            'updated_time' => \Request::input('updated_time'),
            'end_time' => \Request::input('end_time')
        ]);

        return response()->json(['Message' => 'Screen_short Updated']);
    }

    public function get_ScreenShot()
    {
        $ScreenShot = ScreenShot::get();
        return response()->json(['ScreenShot' => $ScreenShot]);
    }

    function delete_ScreenShot(){
        $id = \Request::input('id');
        $ScreenShot = ScreenShot::where('id',$id)->delete();
        
        return response()->json(['message'=>'delete ScreenShot successfully']);
    }

    function take_screenshort(Request $request ){
        $image = $request->screenshot;
        if (!empty($image)) {
            foreach ($image as $key => $value) {
                $data = array(
                    $imageData = base64_decode($value),
                    $filename = uniqid() . '.png',
                    $path = public_path('screenshorts/' . $filename),
                    file_put_contents($path, $imageData),
                );
            }
        }
        return response()->json(['message'=>"added"]);
    }
}
    