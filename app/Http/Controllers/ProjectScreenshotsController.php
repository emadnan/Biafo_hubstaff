<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ProjectScreenshots;
use App\Models\ProjectScreenshotsTiming;
use App\Models\ProjectScreenshotsAttechments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;

class ProjectScreenshotsController extends Controller
{
    public function addProjectScreenshot(Request $request)
    {
        $user_id = $request->user_id;
        $project_id = $request->project_id;
        $stream_name = $request->stream_name;
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $hours = $request->hours;
        $minutes = $request->minutes;
        $seconds = $request->seconds;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $path_url = $request->path_url;
        $isStart = $request->is_start;

        $screenshots = ProjectScreenshots::firstOrCreate(
            [
                'user_id' => $user_id,
                'project_id' => $project_id,
                'date' => date('Y-m-d'),
                'stream_name' => $stream_name

            ],
            [
                'longitude' => $longitude,
                'latitude' => $latitude,
                'hours' => $hours,
                'minutes' => $minutes,
                'seconds' => $seconds
            ]
        );
        $update1 = ProjectScreenshots::where('user_id', $user_id)
        ->where('project_id',$project_id)
        ->where('date',date('Y-m-d'))
        ->where('stream_name',$stream_name)
        ->first();
        if($update1)
        {
            $update1->hours = $hours;
            $update1->minutes = $minutes;
            $update1->seconds = $seconds;
            $update1->save();
        }

        $this->addProjectScreenshotTimings($screenshots->id, $isStart, $start_time, $end_time, $user_id, $project_id, $hours, $minutes, $seconds, $stream_name);

        return response()->json(['Message' => 'Add project screenshots successfully']);
        // print_r($screenshots->id);
        // exit();

    }
    public function addProjectScreenshotTimings($id, $isStart, $start_time, $end_time, $user_id, $project_id, $hours, $minutes, $seconds, $stream_name)
    {

        $timings = new ProjectScreenshotsTiming();
        if ($isStart == 1) {
            $result = ProjectScreenshotsTiming::where('project_screenshorts_id', $id)->where('end_time', null)->orderBy('id', 'DESC')->first();
            if ($result && isset($result->id)) {
                $update = ProjectScreenshotsTiming::where('id', $result->id)->first();
                $update->end_time = $start_time;
                $update->save();
            }
            $timings->project_screenshorts_id = $id;
            $timings->start_time = $start_time;
            $timings->end_time = null;
            $timings->save();
            $screenShots = \Request::input('screenShots');
            
            
            
            if ($screenShots != null) {
                $this->addProjectScreenshotAttechment($result->id);
            }
        } else {

            $result = ProjectScreenshotsTiming::where('project_screenshorts_id', $id)->orderBy('id', 'DESC')->first();
            // $update = ProjectScreenshotsTiming::where('end_time', null)->first();
            $result->end_time = $end_time;
            $result->save();
            $result1 = ProjectScreenshots::where('user_id', $user_id)->where('project_id', $project_id)->where('date', date('Y-m-d'))->where('stream_name',$stream_name)->first();
            $update1 = ProjectScreenshots::where('id', $result1->id)->first();
            $update1->hours = $hours;
            $update1->minutes = $minutes;
            $update1->seconds = $seconds;
            $update1->save();
        }

    }


    public function addProjectScreenshotAttechment($id)
    {
        $screenShots = \Request::input('screenShots');

        if (!empty($screenShots)) {
            foreach ($screenShots as $image) {

                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = uniqid() . '.' . 'png';
                \File::put(public_path() . '/screenshots/' . $imageName, base64_decode($image));
                $path_url = new ProjectScreenshotsAttechments();
                $path_url->project_screenshorts_timing_id = $id;
                $path_url->path_url = asset('screenshots') . '/' . $imageName;
                $path_url->save();
            }
        }
    }

    public function getProjectScreenshots()
    {
        $projectscreenshot = ProjectScreenshots::
            select('users.*','projects.*','company.company_name','project_screenshots.*')    
            ->join('users', 'users.id', '=', 'project_screenshots.user_id')
            ->join('projects', 'projects.id', '=', 'project_screenshots.project_id')
            ->join('company', 'company.id','=','users.company_id')
            ->where('date', date('Y-m-d'))
            ->with('getTimings', 'getTimings.getattechments')
            ->get();

        $totalTime = $projectscreenshot->sum(function ($screenshot) {
            return $screenshot->hours * 3600 + $screenshot->minutes * 60 + $screenshot->seconds;
        });

        $TotalHours = floor($totalTime / 3600);
        $TotalMinutes = floor(($totalTime % 3600) / 60);
        $TotalSeconds = $totalTime % 60;

        $data = compact('projectscreenshot', 'TotalHours', 'TotalMinutes', 'TotalSeconds');
        return response()->json($data);
    }

    public function sum()
    {
        $todayDate = Carbon::today();
        $userId = Auth::id(); // get the authenticated user's ID
        $hours = ProjectScreenshots::where('user_id', $userId)->where('date',$todayDate)->sum('hours');
        $minutes = ProjectScreenshots::where('user_id', $userId)->where('date',$todayDate)->sum('minutes');
        $seconds = ProjectScreenshots::where('user_id', $userId)->where('date',$todayDate)->sum('seconds');
        if($seconds>60){
            $seconds = $seconds - 60;
            $minutes = $minutes + 1;
        }

        if($minutes>60){
            $minutes = $minutes - 60;
            $hours = $hours + 1;
        }
        
        $data = compact('hours', 'minutes', 'seconds');
        return response()->json($data);
    }
    


    public function getProjectScreenshotsByDate($date1, $date2,$user_id)
    {
        if ($date2==0) {
            $projectscreenshot = ProjectScreenshots::select('project_screenshots.*', 'projects.project_name as project_name', 'users.name as user_name')
                ->join('users', 'users.id', '=', 'project_screenshots.user_id')
                ->join('projects', 'projects.id', '=', 'project_screenshots.project_id')
                ->where('date', $date1)
                ->where('user_id',$user_id)
                ->with('getTimings', 'getTimings.getattechments')
                ->get();
        } else {
            $projectscreenshot = ProjectScreenshots::select('project_screenshots.*', 'projects.project_name as project_name', 'users.name as user_name')
                ->join('users', 'users.id', '=', 'project_screenshots.user_id')
                ->join('projects', 'projects.id', '=', 'project_screenshots.project_id')
                ->where('user_id',$user_id)
                ->whereBetween('date', [$date1, $date2])
                ->with('getTimings', 'getTimings.getattechments')
                ->get();
                
        }

        $totalTime = $projectscreenshot->sum(function ($screenshot) {
            return $screenshot->hours * 3600 + $screenshot->minutes * 60 + $screenshot->seconds;
        });

        $TotalHours = floor($totalTime / 3600);
        $TotalMinutes = floor(($totalTime % 3600) / 60);
        $TotalSeconds = $totalTime % 60;

        $data = compact('projectscreenshot', 'TotalHours', 'TotalMinutes', 'TotalSeconds');
        return response()->json($data);
    }
    function getTotalTimebyUserId($userId,$projectId,$streamsName)
    {
        $todayDate = Carbon::today();
        
        $totalTime = ProjectScreenshots::select('project_screenshots.hours as Hours','project_screenshots.minutes as Minutes','project_screenshots.seconds as Seconds')
        ->where('user_id', $userId)
        ->where('project_id',$projectId)
        ->where('stream_name',$streamsName)
        ->where('date',$todayDate)
        ->first();
        
        if($totalTime != null){
            return response()->json($totalTime);
        }
        else{
            $Hours=0;
            $Minutes=0;
            $Seconds=0;
            $data = compact('Hours','Minutes','Seconds');

            return response()->json($data);
        }
    }

}