<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectInfoData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_info', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('project_id')->nullable();
            $table->unsignedInteger('client_id')->nullable();
            $table->unsignedInteger('corporate_id')->nullable();
            $table->string('name')->nullable();
            $table->float('value', 15, 2)->nullable();
            $table->string('contract')->nullable();
            $table->string('gp_propose')->nullable();
            $table->string('gp_latest')->nullable();
            $table->string('job_code')->nullable();
            $table->float('bond', 15, 2)->nullable();
            $table->text('scope')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->boolean('is_process')->nullable();
            $table->boolean('is_approve')->nullable();
            $table->unsignedInteger('workflow_id')->nullable();
            $table->unsignedInteger('creator_id')->nullable();
            $table->unsignedInteger('approved_by')->nullable();
            $table->unsignedInteger('need_step')->nullable();
            $table->unsignedInteger('need_action')->nullable();
            $table->date('approve_date')->nullable();
            $table->string('state')->nullable();
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
         Schema::drop('project_info');
    }
}
