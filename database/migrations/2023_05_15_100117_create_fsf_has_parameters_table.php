<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFsfHasParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fsf_has_parameters', function (Blueprint $table) {
            $table->id();
            $table->integer('fsf_id');
            $table->string('description');
            $table->string('field_technical_name');
            $table->string('field_length');
            $table->string('field_type');
            $table->string('field_table_name');
            $table->string('mandatory_or_optional');
            $table->string('parameter_or_selection');
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
        Schema::dropIfExists('fsf_has_parameters');
    }
}
