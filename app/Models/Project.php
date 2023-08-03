<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Project extends Model
{
    use HasFactory;
    protected $table="projects";
    protected $primaryKey="id";

    function project_manager_details()  {

        return $this->BelongsTo('App\Models\User','project_manager','id');

    }
}
