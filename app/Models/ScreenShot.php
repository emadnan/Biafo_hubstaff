<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenShot extends Model
{
    use HasFactory;
    protected $table="screen_shots";
    protected $primaryKey="id";
}
