<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ProjectScreenshots;
use App\Models\ProjectScreenshotsTiming;
use App\Models\ProjectScreenshotsAttechments;
use Illuminate\Http\Request;

class MailController extends Controller
{
    function sendDailyProgress()  {

        $lastId=ProjectScreenshots::orderBy('id', 'DESC')->first();
        $today = Carbon::today(); // Get the current date as the end date
        $userId=0;
        while ($lastId >= $userId) {
            $hours = ProjectScreenshots::where('user_id', $userId)
            ->where('date', $today)
            ->sum('hours');

            $minutes = ProjectScreenshots::where('user_id', $userId)
                ->where('date', $today)
                ->sum('minutes');

            $seconds = ProjectScreenshots::where('user_id', $userId)
                ->where('date', $today)
                ->sum('seconds');

                while ($seconds >= 60) {
                    $seconds -= 60;
                    $minutes += 1;
                }
            
                while ($minutes >= 60) {
                    $minutes -= 60;
                    $hours += 1;
                }

                $project = ProjectScreenshots::
                join('projects','projects.id','=','project_screenshots.project_id')
                ->where('user_id', $userId)
                ->where('date', $today)
                ->get();

            $data = compact('hours', 'minutes', 'seconds', 'project');
        }
        
        return response()->json(['message'=>'send daily progress to All']);
    }
}
