<?php

namespace App\Http\Controllers;
use App\Models\ProjectScreenshots;
use App\Models\ProjectScreenshotsTiming;
use App\Models\ProjectScreenshotsAttechments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;

class ProjectScreenshotsController extends Controller
{
    public function addProjectScreenshot(Request $request){
        $user_id = $request->user_id;
        $project_id=$request->project_id;
        $stream_name = $request->stream_name;
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $hours= $request->hours;
        $minutes= $request->minutes;
        $seconds=$request->secunds;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $path_url = $request->path_url;
        $isStart = $request->is_start;
    

        $screenshots = ProjectScreenshots::firstOrCreate(
            [
                'user_id'=>$user_id,
                'project_id'=>$project_id,
                'date'=>date('Y-m-d')
            ],
            [
                
                'stream_name'=>$stream_name,
                'longitude'=> $longitude,
                'latitude'=> $latitude,
                'hours'=>$hours,
                'minutes'=> $minutes,
                'seconds'=> $seconds
            ]
        );
        // print_r($screenshots->id);
        // exit();
        $this->addProjectScreenshotTimings($screenshots->id, $isStart, $start_time, $end_time);
        $this->addProjectScreenshotAttechment($screenshots->id);
        
        return response()->json(['Message' => 'Add project screenshots successfully']);
    }
    public function addProjectScreenshotTimings($id, $isStart, $start_time, $end_time){

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

    public function addProjectScreenshotAttechment($id)    {
        $screenShots = \Request::input('screenShots');

        // print_r($screenShots);
        // exit;
        if(!empty($screenShots))    {
            foreach($screenShots as $image )    {
            
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = uniqid().'.'.'png';
                \File::put(public_path(). '/screenshots/' . $imageName, base64_decode($image));
                $path_url = new ProjectScreenshotsAttechments();
                $path_url->project_screenshorts_id = $id;
                $path_url->path_url =asset('screenshots').'/'.$imageName;
                $path_url->save();
            }
        }
    }
}