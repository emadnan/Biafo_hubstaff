<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketNoAndAttechmentIntoTaskManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_managements', function (Blueprint $table) {
            $table->integer('ticket_no')->after('project_id');
            $table->string('attachments')->after('task_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_managements', function (Blueprint $table) {
            $table->dropColumn('ticket_no');
            $table->dropColumn('attachments');
        });
    }
}
