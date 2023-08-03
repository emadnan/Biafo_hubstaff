<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class ChatBoxFsf extends Model
{
    use HasFactory;
    protected $table="chat_box_fsf";
    protected $primaryKey="id";

    function crfChatSenderDetailes(){
        return $this->hasMany('App\Models\User','id','fsf_id');
    }
}
