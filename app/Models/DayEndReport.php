<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayEndReport extends Model
{
    use HasFactory;
    protected $table="day_end_reports";
    protected $primaryKey="id";
}
