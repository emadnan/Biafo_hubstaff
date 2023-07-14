<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_request_forms', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('module_id');
            $table->integer('fsf_id');
            $table->integer('company_id');
            $table->string('implementation_partner');
            $table->dateTime('issuance_date');
            $table->string('author');
            $table->string('doc_ref_no');
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
        Schema::dropIfExists('change_request_forms');
    }
}
