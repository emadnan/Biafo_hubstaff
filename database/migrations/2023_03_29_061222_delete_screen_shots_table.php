<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteScreenShotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('screen_shots');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('screen_shots', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('department_id');
            $table->integer('company_id');
            $table->integer('project_id');
            $table->string('attechment_path');
            $table->dateTime('start_time');
            $table->dateTime('updated_time');
            $table->dateTime('end_time');
            $table->timestamps();
        });
    }
}
