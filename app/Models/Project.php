<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
class Project extends Model
{
    use HasFactory;
    protected $table="projects";
    protected $primaryKey="id";

    function projectManagerDetails()  {

        return $this->hasMany('App\Models\User','id','project_manager');

    }
}
