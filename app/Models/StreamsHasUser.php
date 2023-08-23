<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamsHasUser extends Model
{
    use HasFactory;
    
    protected $table="streams_has_users";
    protected $primaryKey="id";

    function userDetails(){
        return $this->BelongsTo('App\Models\User','user_id','id');
    }

    function assignTypeDetails(){
        return $this->BelongsTo('App\Models\StreamsHasUser','assigning_type_id','id');
    }
}
