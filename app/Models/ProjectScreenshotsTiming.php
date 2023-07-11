<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectScreenshotsTiming extends Model
{
    use HasFactory;
    protected $table="project_screenshots_timings";
    protected $primaryKey="id";

    protected $fillable = [
        'start_time',
        'end_time'
    ];

    function getattechments(){
        return $this->hasMany('App\Models\ProjectScreenshotsAttechments', 'project_screenshorts_timing_id', 'id')
        ->orderBy('id','DESC');
    }
}
