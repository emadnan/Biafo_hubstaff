<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FsfAssignToUser extends Model
{
    use HasFactory;

    protected $table="fsf_assign_to_users";
    protected $primaryKey="id";

    function function_lead_details(){
        return $this->BelongsTo('App\Models\User','user_id','id');
    }

    function getFsfInputParameter(){
        return $this->hasMany('App\Models\FsfHasParameter', 'fsf_id', 'id');
    }

    function getFsfOutputParameter(){
        return $this->hasMany('App\Models\FsfHasOutputParameter', 'fsf_id', 'id');
    }

    function memberDetails(){
        return $this->BelongsTo('App\Models\User','user_id','id');
    }
}
