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

        if ($request->screenshot != "no_image") {
            $image = $request->screenshot;
            // $extension = explode('/', explode(":", substr($image, 0, strpos($image, ";")))[1])[1];
            $extension = "png";
            $replace = substr($image, 0, strpos($image, ',') + 1);
            $image = str_replace($replace, "", $image);
            $image = str_replace('', '+', $image);
            $image_path = time() . '.' . $extension;
            $image_decode = base64_decode($image);
            file_put_contents(public_path() . '/screenshorts/' . $image_path, $image_decode);

            return response()->json(['message'=>'Add ScreenShort successfully']);
        }
    }
}
