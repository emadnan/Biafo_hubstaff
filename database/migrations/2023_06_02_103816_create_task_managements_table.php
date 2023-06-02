<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_managements', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('team_lead_id');
            $table->integer('project_id');
            $table->string('task_description');
            $table->dateTime('start_time');
            $table->dateTime('dead_line');
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
        Schema::dropIfExists('task_managements');
    }
}
