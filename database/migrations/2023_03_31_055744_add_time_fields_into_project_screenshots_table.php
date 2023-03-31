<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeFieldsIntoProjectScreenshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_screenshots', function (Blueprint $table) {
            $table->integer('hours')->nullable()->after('date');
            $table->integer('minutes')->nullable()->after('hours');
            $table->integer('seconds')->nullable()->after('minutes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_screenshots', function (Blueprint $table) {
            $table->dropColumn('hours');
            $table->dropColumn('minutes');
            $table->dropColumn('seconds');
        });
    }
}
