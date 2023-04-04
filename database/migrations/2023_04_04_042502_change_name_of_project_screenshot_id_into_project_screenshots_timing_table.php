<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNameOfProjectScreenshotIdIntoProjectScreenshotsTimingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_screenshots_attachments', function (Blueprint $table) {
            $table->renameColumn('project_screenshorts_attechment_id', 'project_screenshorts_timing_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_screenshots_attachments', function (Blueprint $table) {
            $table->renameColumn('project_screenshorts_timing_id', 'project_screenshorts_attechment_id');
        });
    }
}
