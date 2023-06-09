<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndCommentsIntoTaskManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_managements', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'InProgress', 'Completed'])->default('Pending')->after('dead_line')->nullable();
            $table->string('comment')->after('status')->nullable();
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
            $table->dropColumn('status');
            $table->dropColumn('comment');
        });
    }
}
