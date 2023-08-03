<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBoxFsfToUser extends Model
{
    use HasFactory;

    protected $table="chat_box_fsf_to_employee";
    protected $primaryKey="id";

    function crfChatSenderDetailes(){
        return $this->hasMany('App\Models\User','id','fsf_id');
    }
}
