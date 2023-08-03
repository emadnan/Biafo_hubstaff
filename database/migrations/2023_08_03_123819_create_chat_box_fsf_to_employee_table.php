<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatBoxFsfToEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_box_fsf_to_employee', function (Blueprint $table) {
            $table->id();
            $table->integer('fsf_id');
            $table->integer('sender_id');
            $table->string('messages',1000);
            $table->dateTime('message_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_box_fsf_to_employee');
    }
}
