<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_payment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('project_id')->nullable();
            $table->date('claim_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->unsignedInteger('claim_report_by')->nullable();
            $table->unsignedInteger('paid_report_by')->nullable();
            $table->double('claim_amout')->nullable();
            $table->double('paid_amount')->nullable();
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
        Schema::drop('project_payment');
    }
}
