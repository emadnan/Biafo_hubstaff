<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Streams extends Model
{
    use HasFactory;
    protected $table="streams";
    protected $primaryKey="id";

    function projectDetails(){
        return $this->BelongsTo('App\Models\projects','project_id','id');
    }
}
