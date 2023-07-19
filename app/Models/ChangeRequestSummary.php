<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeRequestSummary extends Model
{
    use HasFactory;

    protected $table="change_request_summary";
    protected $primaryKey="id";

    function crfDdetails(){
        return $this->BelongsTo('App\Models\change_request_forms','crf_id','id');
    }
}
