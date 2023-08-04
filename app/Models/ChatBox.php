<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBox extends Model
{
    use HasFactory;
    
    protected $table="chat_box_crf";
    protected $primaryKey="id";

    function crfChatSenderDetailes(){
        return $this->hasMany('App\Models\User','id','sender_id');
    }
}
