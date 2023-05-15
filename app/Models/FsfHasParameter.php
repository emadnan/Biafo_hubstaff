<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FsfHasParameter extends Model
{
    use HasFactory;
    protected $table="fsf_has_parameters";
    protected $primaryKey="id";
}
