<?php

namespace App\Http\Controllers;
use App\Models\ProjectScreenshots;
use App\Models\ProjectScreenshotsTiming;
use App\Models\ProjectScreenshotsAttechments;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ProjectScreenshotsController extends Controller
{
    public function addProjectScreenshot(Request $request){
        $user_id = $request->user_id;
        $stream_name = $request->stream_name;
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $path_url = $request->path_url;
        $isStart = $request->is_start;
    

        $screenshots = ProjectScreenshots::firstOrCreate(
            [
                'user_id'=>$user_id,
                'stream_name'=>$stream_name,
                'date'=>date('Y-m-d')
            ],
            [
                'longitude'=> $longitude,
                'latitude'=> $latitude
            ]
        );
        // print_r($screenshots->id);
        // exit();
        $this->addProjectScreenshotTimings($screenshots->id, $isStart, $start_time, $end_time);
        $this->addProjectScreenshotAttechment($screenshots->id);
        
        return response()->json(['Message' => 'Add project screenshots successfully']);
    }
    public function addProjectScreenshotTimings($id, $isStart, $start_time, $end_time)
    {
        $timings = new ProjectScreenshotsTiming();
        if($isStart == 1){     
            $timings->project_screenshorts_id = $id;
            $timings->start_time = $start_time;
            $timings->end_time = null;
            $timings->save();
    }
    else{
        
        $result = ProjectScreenshotsTiming::where('project_screenshorts_id', $id)->where('end_time', null)->orderBy('id','DESC')->first();
        $update = ProjectScreenshotsTiming::where('id', $result->id)
        ->update(['end_time' => $end_time]);
        
    }
    }

    public function addProjectScreenshotAttechment($id){
        $screenShots = \Request::input('screenShots');
        // print_r($screenShots);
        // exit;
        if(!empty($screenShots)){
        foreach($screenShots as $key => $value ){
        $path_url = new ProjectScreenshotsAttechments();
        $path_url->project_screenshorts_id = $id;
        $path_url->path_url = $value['path_url'];
        $path_url->save();
        }
    }
    }
}