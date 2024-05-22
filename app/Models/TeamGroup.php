<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamGroup extends Model
{
    use HasFactory;

    protected $table="team_groups";
    protected $primaryKey="id";
}
