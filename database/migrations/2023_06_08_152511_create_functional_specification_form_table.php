<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunctionalSpecificationFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('functional_specification_form', function (Blueprint $table) {
            $table->id();
            $table->integer('module_id');
            $table->integer('project_id');
            $table->integer('functional_lead_id');
            $table->integer('ABAP_team_lead_id');
            $table->string('wricef_id');
            $table->string('type_of_development');
            $table->dateTime('requested_date');
            $table->string('priority');
            $table->string('usage_frequency');
            $table->string('transaction_code');
            $table->string('authorization_role');
            $table->text('development_logic');
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
        Schema::dropIfExists('functional_specification_form');
    }
}
