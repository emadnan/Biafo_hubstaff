<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupHasUser extends Model
{
    use HasFactory;

    protected $table="group_has_user";
    protected $primaryKey="id";
}
