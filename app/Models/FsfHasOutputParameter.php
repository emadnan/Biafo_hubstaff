<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FsfHasOutputParameter extends Model
{
    use HasFactory;
    protected $table="fsf_has_output_parameters";
    protected $primaryKey="id";
}
