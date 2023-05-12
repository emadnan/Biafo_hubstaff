<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamHasUser extends Model
{
    use HasFactory;
    protected $table="team_has_users";
    protected $primaryKey="id";
}
