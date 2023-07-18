<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChangeRequestForm extends Model
{
    use HasFactory;
    protected $table="change_request_forms";
    protected $primaryKey="id";

    function project_details(){
        return $this->BelongsTo('App\Models\Project','project_id','id');
    }

    function module_details(){
        return $this->BelongsTo('App\Models\Module','module_id','id');
    }

    function company_details(){
        return $this->hasMany('App\Models\Company', 'company_id', 'id');
    }

    function FSF_details(){
        return $this->hasMany('App\Models\FunctionalSpecificationForm', 'fsf_id', 'id');
    }
}
