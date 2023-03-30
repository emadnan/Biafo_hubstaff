<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectScreenshotsAttechments extends Model
{
    use HasFactory;
    protected $table="project_screenshots_attachments";
    protected $primaryKey="id";

    protected $fillable = ['project_screenshorts_id','path_url'];
}
