<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypesOfLatitudeAndLongitudeIntoProjectScreenshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_screenshots', function (Blueprint $table) {
            $table->float('longitude')->change();
            $table->float('latitude')->change();
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
            $table->integer('longitude')->change();
            $table->integer('latitude')->change();
        });
    }
}
