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
        $seconds=$request->seconds;
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
        $this->addProjectScreenshotTimings($screenshots->id, $isStart, $start_time, $end_time, $user_id, $project_id, $hours, $minutes, $seconds);
        
        return response()->json(['Message' => 'Add project screenshots successfully']);
        // print_r($screenshots->id);
        // exit();
        
    }
    public function addProjectScreenshotTimings($id, $isStart, $start_time, $end_time, $user_id, $project_id, $hours, $minutes, $seconds){

        $timings = new ProjectScreenshotsTiming();
        if($isStart == 1){     

            $timings->project_screenshorts_id = $id;
            $timings->start_time = $start_time;
            $timings->end_time = null;
            $timings->save();
            $screenShots = \Request::input('screenShots');
            if($screenShots != null)
            {
                $this->addProjectScreenshotAttechment($timings->id);
            }
        }
        else{
            

            // $result1 = ProjectScreenshotsTiming::where('project_screenshorts_id', $id)->orderBy('id','DESC')->first();
            // $update1 = ProjectScreenshotsTiming::where('id', $result1->id-1)
            // ->update(['end_time' => $start_time]);
            // print_r('rafay Ch');
            // exit();
            $result = ProjectScreenshotsTiming::where('project_screenshorts_id', $id)->orderBy('id','DESC')->first();
            $update = ProjectScreenshotsTiming::where('end_time', null)->first();
            $update->end_time = $end_time;
            $update->save();
            $result1 = ProjectScreenshots::where('user_id',$user_id)->where('project_id',$project_id)->where('date',date('Y-m-d'))->first();
            $update1 = ProjectScreenshots::where('id',$result1->id)->first();
            $update1->hours = $hours;
            $update1->minutes = $minutes;
            $update1->seconds = $seconds;
   
            $update1->save();            
        }       
        
    }

    public function addProjectScreenshotAttechment($id)    {
        $screenShots = \Request::input('screenShots');

        if(!empty($screenShots))    {
            foreach($screenShots as $image )    {
            
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = uniqid().'.'.'png';
                \File::put(public_path().'/screenshots/'.$imageName, base64_decode($image));
                $path_url = new ProjectScreenshotsAttechments();
                $path_url->project_screenshorts_timing_id = $id;
                $path_url->path_url =asset('screenshots').'/'.$imageName;
                $path_url->save();
            }
        }
    }

    public function getProjectScreenshots(){
        $projectscreenshot= ProjectScreenshots::select('project_screenshots.*','projects.project_name as project_name','users.name as user_name')
        ->join('users','users.id','=','project_screenshots.user_id')
        ->join('projects','projects.id','=','project_screenshots.project_id')
        ->where('date',date('Y-m-d'))
        ->with('getTimings','getTimings.getattechments')
        ->get();

        $totalTime = $projectscreenshot->sum(function ($screenshot) {
            return $screenshot->hours * 3600 + $screenshot->minutes * 60 + $screenshot->seconds;
        });
        
        $totalhours = floor($totalTime / 3600);
        $totalminutes = floor(($totalTime % 3600) / 60);
        $totalseconds = $totalTime % 60;
        return response()->json(['ProjectScreenshot' => $projectscreenshot, 'totalhours'=> $totalhours, 'totalminutes'=>$totalminutes, 'totalseconds'=>$totalseconds]);
    }

}