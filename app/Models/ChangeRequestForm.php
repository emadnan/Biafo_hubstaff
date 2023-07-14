<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeRequestForm extends Model
{
    use HasFactory;
    protected $table="change_request_forms";
    protected $primaryKey="id";
}
