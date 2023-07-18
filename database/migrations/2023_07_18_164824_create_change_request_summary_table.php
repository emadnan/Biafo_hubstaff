<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeRequestSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_request_summary', function (Blueprint $table) {
            $table->id();
            $table->integer('crf_id');
            $table->string('requirement');
            $table->string('required_time_no');
            $table->string('required_time_type');
            $table->enum('functional_resource', ['Yes', 'No'])->default('Yes');
            $table->enum('Technical_resource', ['Yes', 'No'])->default('Yes');
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
        Schema::dropIfExists('change_request_summary');
    }
}
