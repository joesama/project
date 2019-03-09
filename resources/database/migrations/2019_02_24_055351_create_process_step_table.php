<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessStepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_step', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('process_flow_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('delete_by')->nullable();
            $table->text('label')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('order')->nullable();
            $table->unsignedInteger('status_id')->nullable();
            $table->unsignedInteger('role_id')->nullable();
            $table->boolean('cross_organisation')->nullable()->default(false);
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
        Schema::drop('process_step');
    }
}
