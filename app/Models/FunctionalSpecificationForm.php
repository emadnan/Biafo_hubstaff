<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FunctionalSpecificationForm extends Model
{
    use HasFactory;
    protected $table="functional_specification_form";
    protected $primaryKey="id";

    function function_lead_details(){
        return $this->BelongsTo('App\Models\User','functional_lead_id','id');
    }

    function team_lead_details(){
        return $this->BelongsTo('App\Models\User','ABAP_team_lead_id','id');
    }

    function getFsfParameter(){
        return $this->hasMany('App\Models\FsfHasParameter', 'fsf_id', 'id');
    }
}
