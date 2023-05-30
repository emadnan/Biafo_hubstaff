<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FsfAssignToUser extends Model
{
    use HasFactory;

    protected $table="fsf_assign_to_users";
    protected $primaryKey="id";
}
