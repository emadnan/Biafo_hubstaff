<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeSubscriptionInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_invoices', function (Blueprint $table) {
            $table->dateTime('end_date')->nullable()->change();
            $table->dateTime('start_date')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_invoices', function (Blueprint $table) {

            $table->string('end_date')->change();
            $table->string('start_date')->change();
        });
    }
}
