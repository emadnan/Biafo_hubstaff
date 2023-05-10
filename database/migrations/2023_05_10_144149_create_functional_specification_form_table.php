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
            $table->string('wricef_id');
            $table->string('module_name');
            $table->string('functional_lead');
            $table->date('requested_date');
            $table->string('type_of_development');
            $table->string('priority');
            $table->string('usage_frequency');
            $table->string('transaction_code');
            $table->string('authorization_level');
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
        Schema::dropIfExists('functional_specification_form');
    }
}
