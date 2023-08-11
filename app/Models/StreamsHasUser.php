<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamsHasUser extends Model
{
    use HasFactory;
    
    protected $table="streams_has_users";
    protected $primaryKey="id";
}
