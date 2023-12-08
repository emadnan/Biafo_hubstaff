<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldsIntoProjectScreenshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_screenshots', function (Blueprint $table) {
            $table->string('platform')->after('latitude')->nullable();
            $table->string('type')->after('platform')->nullable();
            $table->string('release')->after('type')->nullable();
            $table->string('hostname')->after('release')->nullable();
            $table->string('ip')->after('hostname')->nullable();
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
            $table->dropColumn('platform');
            $table->dropColumn('type');
            $table->dropColumn('release');
            $table->dropColumn('hostname');
            $table->dropColumn('ip');
        });
    }
}
