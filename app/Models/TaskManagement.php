<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskManagement extends Model
{
    use HasFactory;

    protected $table="task_managements";
    protected $primaryKey="id";

    function team_lead_details(){
        return $this->BelongsTo('App\Models\User','team_lead_id','id');
    }
}
