<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectScreenshots extends Model
{
    use HasFactory;
    protected $table="project_screenshots";
    protected $primaryKey="id";

    protected $fillable = ['user_id', 'stream_name','longitude', 'latitude', 'date'];

}
