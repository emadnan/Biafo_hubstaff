<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBoxForTask extends Model
{
    use HasFactory;
    protected $table="chat_box_for_tasks";
    protected $primaryKey="id";

    function crfChatSenderDetailes(){
        return $this->hasMany('App\Models\User','id','fsf_id');
    }
}
