<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamsHasUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streams_has_users', function (Blueprint $table) {
            $table->id();
            $table->integer('stream_id');
            $table->integer('user_id');
            $table->enum('assinging_type', ['Partially', 'Fulltime'])->default('Fulltime');
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
        Schema::dropIfExists('streams_has_users');
    }
}
