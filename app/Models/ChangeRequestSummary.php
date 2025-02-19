<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChangeRequestSummary extends Model
{
    use HasFactory;

    protected $table="change_request_summary";
    protected $primaryKey="id";

    function crfDdetails(){
        return $this->BelongsTo('App\Models\ChangeRequestForm','crf_id','id');
    }
}
