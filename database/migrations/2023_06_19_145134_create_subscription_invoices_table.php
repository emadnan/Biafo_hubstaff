<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('stripe_id');
            $table->string('company_id');
            $table->string('subscription_id');
            $table->string('amount');
            $table->string('start_date');
            $table->string('end_date');
            $table->Integer('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_invoices');
    }
}
