<?php

namespace App\Http\Controllers;

use App\Models\ProjectScreenshots;
use App\Models\ProjectScreenshotsAttechments;
use App\Models\ProjectScreenshotsTiming;
use App\Models\Team;
use App\Models\TeamHasUser;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

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
        $platform = $request->platform;
        $release = $request->release;
        $type = $request->type;
        $hostname = $request->hostname;
        $ip = $request->ip;

        $screenshots = ProjectScreenshots::firstOrCreate(
            [
                'user_id' => $user_id,
                'project_id' => $project_id,
                'date' => date('Y-m-d'),
                'stream_name' => $stream_name,

            ],
            [
                'longitude' => $longitude,
                'latitude' => $latitude,
                'hours' => $hours,
                'minutes' => $minutes,
                'seconds' => $seconds,
                'platform' => $platform,
                'release' => $release,
                'type' => $type,
                'hostname' => $hostname,
                'ip' => $ip,

            ]
        );
        $update1 = ProjectScreenshots::where('user_id', $user_id)
            ->where('project_id', $project_id)
            ->where('date', date('Y-m-d'))
            ->where('stream_name', $stream_name)
            ->first();
        if ($update1) {
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
            $result1 = ProjectScreenshots::where('user_id', $user_id)->where('project_id', $project_id)->where('date', date('Y-m-d'))->where('stream_name', $stream_name)->first();
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

                // Reduce the image size to maximum 30KB
                $image = Image::make(base64_decode($image))
                    ->resize(830, 530)
                    ->encode('png');

                \File::put(public_path() . '/screenshots/' . $imageName, $image);
                $path_url = new ProjectScreenshotsAttechments();
                $path_url->project_screenshorts_timing_id = $id;
                $path_url->path_url = $imageName;
                $path_url->save();
            }
        }
    }

    public function getProjectScreenshots()
    {
        $projectscreenshot = ProjectScreenshots::
            select('users.*', 'projects.*', 'company.company_name', 'project_screenshots.*')
            ->join('users', 'users.id', '=', 'project_screenshots.user_id')
            ->join('projects', 'projects.id', '=', 'project_screenshots.project_id')
            ->join('company', 'company.id', '=', 'users.company_id')
            ->where('date', date('Y-m-d'))
            ->with('getTimings', 'getTimings.getattechments')
            ->orderBy('project_screenshots.id', 'DESC')
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
        $hours = ProjectScreenshots::where('user_id', $userId)->where('date', $todayDate)->sum('hours');
        $minutes = ProjectScreenshots::where('user_id', $userId)->where('date', $todayDate)->sum('minutes');
        $seconds = ProjectScreenshots::where('user_id', $userId)->where('date', $todayDate)->sum('seconds');
        if ($seconds > 60) {
            $seconds = $seconds - 60;
            $minutes = $minutes + 1;
        }

        if ($minutes > 60) {
            $minutes = $minutes - 60;
            $hours = $hours + 1;
        }

        $data = compact('hours', 'minutes', 'seconds');
        return response()->json($data);
    }

    public function getProjectScreenshotsByDate($date1, $user_id)
    {

        $projectscreenshot = ProjectScreenshots::select('project_screenshots.*', 'projects.project_name as project_name', 'users.name as user_name')
            ->join('users', 'users.id', '=', 'project_screenshots.user_id')
            ->join('projects', 'projects.id', '=', 'project_screenshots.project_id')
            ->where('date', $date1)
            ->where('user_id', $user_id)
            ->with('getTimings', 'getTimings.getattechments')
            ->orderBy('project_screenshots.id', 'DESC')
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
    public function getTotalTimebyUserId($userId, $projectId, $streamsName)
    {
        $todayDate = Carbon::today();

        $totalTime = ProjectScreenshots::select('project_screenshots.hours as Hours', 'project_screenshots.minutes as Minutes', 'project_screenshots.seconds as Seconds')
            ->where('user_id', $userId)
            ->where('project_id', $projectId)
            ->where('stream_name', $streamsName)
            ->where('date', $todayDate)
            ->first();

        if ($totalTime != null) {
            return response()->json($totalTime);
        } else {
            $Hours = 0;
            $Minutes = 0;
            $Seconds = 0;
            $data = compact('Hours', 'Minutes', 'Seconds');

            return response()->json($data);
        }
    }

    public function updateTimeAfterOneMinute(Request $request)
    {

        $user_id = $request->user_id;
        $project_id = $request->project_id;
        $stream_name = $request->stream_name;
        $hours = $request->hours;
        $minutes = $request->minutes;
        $seconds = $request->seconds;

        $update1 = ProjectScreenshots::where('user_id', $user_id)
            ->where('project_id', $project_id)
            ->where('date', date('Y-m-d'))
            ->where('stream_name', $stream_name)
            ->first();
        if ($update1) {
            $update1->hours = $hours;
            $update1->minutes = $minutes;
            $update1->seconds = $seconds;
            $update1->save();
        }

        return response()->json(['data' => $update1, 'message' => 'Add project screenshots successfully']);
    }

    public function getTotalWorkbyUserId($userId)
    {
        $todayDate = Carbon::today();
        $hours = ProjectScreenshots::where('user_id', $userId)->where('date', $todayDate)->sum('hours');
        $minutes = ProjectScreenshots::where('user_id', $userId)->where('date', $todayDate)->sum('minutes');
        $seconds = ProjectScreenshots::where('user_id', $userId)->where('date', $todayDate)->sum('seconds');
        while ($seconds >= 60) {
            $seconds -= 60;
            $minutes += 1;
        }

        while ($minutes >= 60) {
            $minutes -= 60;
            $hours += 1;
        }

        $data = compact('hours', 'minutes', 'seconds');
        return response()->json($data);
    }

    public function getProjectScreenshotsByDateWithCompanyId($date1, $company_id)
    {
        $projectscreenshot = ProjectScreenshots::select('project_screenshots.*', 'projects.project_name as project_name', 'users.name as user_name')
            ->join('users', 'users.id', '=', 'project_screenshots.user_id')
            ->join('company', 'company.id', '=', 'users.company_id')
            ->join('projects', 'projects.id', '=', 'project_screenshots.project_id')
            ->where('date', $date1)
            ->where('company.id', $company_id)
            ->with('getTimings', 'getTimings.getattechments')
            ->orderBy('project_screenshots.id', 'DESC')
            ->get();

        return response()->json($projectscreenshot);
    }

    public function sumByDateWithUserId($date1, $userId)
    {

        $hours = ProjectScreenshots::where('user_id', $userId)->where('date', $date1)->sum('hours');
        $minutes = ProjectScreenshots::where('user_id', $userId)->where('date', $date1)->sum('minutes');
        $seconds = ProjectScreenshots::where('user_id', $userId)->where('date', $date1)->sum('seconds');
        while ($seconds >= 60) {
            $seconds -= 60;
            $minutes += 1;
        }

        while ($minutes >= 60) {
            $minutes -= 60;
            $hours += 1;
        }

        $projects = ProjectScreenshots::
            join('projects', 'projects.id', '=', 'project_screenshots.project_id')
            ->where('user_id', $userId)
            ->where('date', $date1)
            ->get();

        $data = compact('hours', 'minutes', 'seconds', 'projects');
        return response()->json($data);
    }

    public function calculateWeeklyWork()
    {
        $userId = Auth::id(); // get the authenticated user's ID

        $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY); // Get the start of the current week (Monday)
        $endDate = Carbon::today(); // Get the current date as the end date

        $hours = ProjectScreenshots::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('hours');

        $minutes = ProjectScreenshots::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('minutes');

        $seconds = ProjectScreenshots::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('seconds');

        while ($seconds >= 60) {
            $seconds -= 60;
            $minutes += 1;
        }

        while ($minutes >= 60) {
            $minutes -= 60;
            $hours += 1;
        }

        $data = compact('hours', 'minutes', 'seconds');
        return response()->json($data);
    }

    public function calculateWeeklyActivity($userId)
    {

        $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY); // Get the start of the current week (Monday)
        $endDate = Carbon::today(); // Get the current date as the end date

        $hours = ProjectScreenshots::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('hours');

        $minutes = ProjectScreenshots::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('minutes');

        $seconds = ProjectScreenshots::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
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
            join('projects', 'projects.id', '=', 'project_screenshots.project_id')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $data = compact('hours', 'minutes', 'seconds', 'project');
        return response()->json($data);
    }

    public function calculateDailyActivity($userId)
    {

        $today = Carbon::today(); // Get the current date as the end date

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
            join('projects', 'projects.id', '=', 'project_screenshots.project_id')
            ->where('user_id', $userId)
            ->where('date', $today)
            ->get();

        $data = compact('hours', 'minutes', 'seconds', 'project');
        return response()->json($data);
    }

    public function calculateMonthlyActivity($userId)
    {

        $startDate = Carbon::now()->startOfMonth(); // Get the start of the current monthly
        $endDate = Carbon::today(); // Get the current date as the end date

        $hours = ProjectScreenshots::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('hours');

        $minutes = ProjectScreenshots::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('minutes');

        $seconds = ProjectScreenshots::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
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
            join('projects', 'projects.id', '=', 'project_screenshots.project_id')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $data = compact('hours', 'minutes', 'seconds', 'project');
        return response()->json($data);
    }

    public function calculateOverAllActivity($userId)
    {

        $hours = ProjectScreenshots::where('user_id', $userId)
            ->sum('hours');

        $minutes = ProjectScreenshots::where('user_id', $userId)
            ->sum('minutes');

        $seconds = ProjectScreenshots::where('user_id', $userId)
            ->sum('seconds');

        while ($seconds >= 60) {
            $seconds -= 60;
            $minutes += 1;
        }

        while ($minutes >= 60) {
            $minutes -= 60;
            $hours += 1;
        }

        $data = compact('hours', 'minutes', 'seconds');

        return response()->json($data);
    }

    public function sumByDatesWithUserId($date1, $date2, $userId)
    {

        $hours = ProjectScreenshots::where('user_id', $userId)->whereBetween('date', [$date1, $date2])->sum('hours');
        $minutes = ProjectScreenshots::where('user_id', $userId)->whereBetween('date', [$date1, $date2])->sum('minutes');
        $seconds = ProjectScreenshots::where('user_id', $userId)->whereBetween('date', [$date1, $date2])->sum('seconds');

        while ($seconds >= 60) {
            $seconds -= 60;
            $minutes += 1;
        }

        while ($minutes >= 60) {
            $minutes -= 60;
            $hours += 1;
        }

        $projects = ProjectScreenshots::
            join('projects', 'projects.id', '=', 'project_screenshots.project_id')
            ->where('user_id', $userId)
            ->whereBetween('date', [$date1, $date2])
            ->get();

        $data = compact('hours', 'minutes', 'seconds', 'projects');

        return response()->json($data);
    }

    public function addidleTime(Request $request)
    {

        $user_id = $request->user_id;
        $project_id = $request->project_id;
        $stream_name = $request->stream_name;
        $hours = $request->hours;
        $minutes = $request->minutes;
        $seconds = $request->seconds;
        $todayDate = Carbon::today();
        // Retrieve the existing record from the database
        $update1 = ProjectScreenshots::where('user_id', $user_id)
            ->where('project_id', $project_id)
            ->where('date', $todayDate)
            ->where('stream_name', $stream_name)
            ->first();

        if ($update1) {
            // Update the seconds and minutes attributes with the new calculated values
            $update1->seconds = $update1->seconds + $seconds;
            $update1->minutes = $update1->minutes + $minutes;
            $update1->hours = $update1->hours + $hours;

            while ($update1->seconds >= 60) {
                $update1->seconds -= 60;
                $update1->minutes += 1;
            }

            while ($update1->minutes >= 60) {
                $update1->minutes -= 60;
                $update1->hours += 1;
            }

            // Save the updated object back to the database
            $update1->save();
        }

        return response()->json(['data' => $update1, 'message' => 'Add project screenshots successfully']);
    }

    public function getProjectScreenshotsByTeamLead($user_id, $teamleadId, $date)
    {
        $user = DB::table('users')
            ->where('id', $teamleadId)
            ->first();

        if ($user->role != 6 && $user->role != 7) {
            return response()->json(['error' => 'You are not authorized to access this resource.'], 403);
        }

        $team_id = DB::table('teams')
            ->where('team_lead_id', $user->id)
            ->value('id');

        $user_ids = DB::table('team_has_users')
            ->where('team_id', $team_id)
            ->pluck('user_id')
            ->toArray();

        // print_r($user_ids);
        // exit();

        if (!in_array($user_id, $user_ids)) {
            return response()->json(['error' => 'The user is not in your team.'], 403);
        }

        $projectscreenshot = ProjectScreenshots::
            select('users.*', 'projects.*', 'company.company_name', 'project_screenshots.*')
            ->join('users', 'users.id', '=', 'project_screenshots.user_id')
            ->join('projects', 'projects.id', '=', 'project_screenshots.project_id')
            ->join('company', 'company.id', '=', 'users.company_id')
            ->where('date', $date)
            ->where('users.id', $user_id)
            ->with('getTimings', 'getTimings.getattechments')
            ->orderBy('project_screenshots.id', 'DESC')
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

    public function getDailyReportOfUsersForTeamLead($team_lead_id, $date)
    {
        $team = Team::where('team_lead_id', $team_lead_id)->first();

        if (!$team) {
            return response()->json(['error' => 'Team lead not found'], 404);
        }

        $user_ids = TeamHasUser::where('team_id', $team->id)->pluck('user_id')->toArray();

        $projectscreenshot = ProjectScreenshots::
            select('users.*', 'projects.*', 'company.company_name', 'project_screenshots.*')
            ->join('users', 'users.id', '=', 'project_screenshots.user_id')
            ->join('projects', 'projects.id', '=', 'project_screenshots.project_id')
            ->join('company', 'company.id', '=', 'users.company_id')
            ->whereIn('users.id', $user_ids)
            ->where('date', $date)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('project_screenshots')
                    ->whereRaw('project_screenshots.user_id = users.id');
            })
            ->with('getTimings')
            ->orderBy('project_screenshots.id', 'DESC')
            ->get();

        $totalTimes = $projectscreenshot->groupBy('user_id')->map(function ($group) {
            return $group->sum(function ($item) {
                return $item->hours * 3600 + $item->minutes * 60 + $item->seconds;
            });
        });

        $users = User::whereIn('id', $user_ids)->get();

        $data = [];
        foreach ($users as $user) {
            if ($totalTimes->has($user->id)) {
                $totalTime = $totalTimes[$user->id];
                $totalHours = floor($totalTime / 3600);
                $totalMinutes = floor(($totalTime % 3600) / 60);
                $totalSeconds = $totalTime % 60;

                $user->totalHours = $totalHours;
                $user->totalMinutes = $totalMinutes;
                $user->totalSeconds = $totalSeconds;

                $data[] = $user;
            }
        }

        return response()->json(['data' => $data]);
    }

    public function getDailyReportOfOfflineUsersByTeamLead($team_lead_id, $date)
    {
        $team = Team::where('team_lead_id', $team_lead_id)->first();

        if (!$team) {
            return response()->json(['error' => 'Team lead not found'], 404);
        }

        $user_ids = TeamHasUser::where('team_id', $team->id)->pluck('user_id')->toArray();

        $offlineUserIds = User::whereNotIn('id', function ($query) use ($date) {
            $query->select('user_id')
                ->from('project_screenshots')
                ->whereDate('date', $date);
        })->whereIn('id', $user_ids)->pluck('id')->toArray();

        $users = User::whereIn('id', $offlineUserIds)->get();

        return response()->json(['data' => $users]);
    }

    public function getDailyReportBothOfflineOrOnline($team_lead_id, $date)
    {
        $team = Team::where('team_lead_id', $team_lead_id)->first();

        if (!$team) {
            return response()->json(['error' => 'Team lead not found'], 404);
        }

        $user_ids = TeamHasUser::where('team_id', $team->id)->pluck('user_id')->toArray();

        $projectscreenshot = ProjectScreenshots::
            select('users.*', 'projects.*', 'company.company_name', 'project_screenshots.*')
            ->rightJoin('users', 'users.id', '=', 'project_screenshots.user_id')
            ->join('projects', 'projects.id', '=', 'project_screenshots.project_id')
            ->join('company', 'company.id', '=', 'users.company_id')
            ->where('date', $date)
            ->whereIn('users.id', $user_ids)
            ->with('getTimings')
            ->orderBy('project_screenshots.id', 'DESC')
            ->get();

        $totalTimes = $projectscreenshot->groupBy('user_id')->map(function ($group) {
            return $group->sum(function ($item) {
                return $item->hours * 3600 + $item->minutes * 60 + $item->seconds;
            });
        });

        $offlineUserIds = User::whereNotIn('id', function ($query) use ($date) {
            $query->select('user_id')
                ->from('project_screenshots')
                ->whereDate('date', $date);
        })->whereIn('id', $user_ids)->pluck('id')->toArray();

        $offlineUsers = User::whereIn('id', $offlineUserIds)->get();

        $users = collect([]);
        foreach ($totalTimes as $userId => $totalTime) {
            $user = User::find($userId);
            if ($user) {
                $user->totalHours = floor($totalTime / 3600);
                $user->totalMinutes = floor(($totalTime % 3600) / 60);
                $user->totalSeconds = $totalTime % 60;
                $users->push($user);
            }
        }

        return response()->json(['data' => $users, 'offlineUsers' => $offlineUsers]);
    }

    function getReportsWithDateRange( $user_id, $fromdate, $todate){

        $projectscreenshot = ProjectScreenshots::select('project_screenshots.*', 'projects.project_name as project_name', 'users.name as user_name')
            ->join('users', 'users.id', '=', 'project_screenshots.user_id')
            ->join('projects', 'projects.id', '=', 'project_screenshots.project_id')
            ->where('user_id', $user_id)
            ->whereBetween('project_screenshots.date', [$fromdate, $todate])
            ->with('getTimings', 'getTimings.getattechments')
            ->orderBy('project_screenshots.id', 'DESC')
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
}
