<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectCardData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_card', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('project_id')->nullable();
            $table->unsignedInteger('workflow_id')->nullable();
            $table->unsignedInteger('creator_id')->nullable();
            $table->unsignedInteger('need_action')->nullable();
            $table->text('month')->nullable();
            $table->date('card_date')->nullable();
            $table->date('card_end')->nullable();
            $table->date('verify')->nullable();
            $table->date('approved')->nullable();
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
        Schema::drop('project_card');
    }
}
