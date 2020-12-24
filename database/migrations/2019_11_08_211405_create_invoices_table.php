<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('billing_address_id');
            $table->unsignedBigInteger('job_address_id');
            $table->string('sales_person', 25);
            $table->string('billing_date', 15);
            $table->text('description');
            $table->text('cost_description');
            $table->boolean('completed');
            $table->boolean('paid');
            $table->string('total', 10);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('billing_address_id')->references('id')->on('addresses');
            $table->foreign('job_address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
