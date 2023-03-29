<?php

namespace App\Http\Controllers;
use App\Models\ProjectScreenshots;
use App\Models\ProjectScreenshotsTiming;
use App\Models\ProjectScreenshotsAttechments;
use Illuminate\Http\Request;

class ProjectScreenshotsController extends Controller
{
    public function Add_project_screenshots(){
        
        $screenshots = ProjectScreenshots::firstOrCreate([
            'user_id'=>'1',
            'stream_name'=>'shshs'
        ],
        [
            'user_id'=>\Request::input('department_id'),
            'stream_name'=>\Request::input('stream_name'),
            'longitude'=>\Request::input('longitude'),
            'latitude'=>\Request::input('latitude'),
            'date'=>\Request::input('date')
        ]
    );
        return response()->json(['Message' => 'Add project screenshots successfully']);
    }
}