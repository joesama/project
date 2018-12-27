<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('client_id')->nullable();
            $table->integer('corporate_id')->nullable();
            $table->string('name')->nullable();
            $table->string('value')->nullable();
            $table->string('contract')->nullable();
            $table->string('gp_propose')->nullable();
            $table->string('gp_latest')->nullable();
            $table->double('bond')->nullable();
            $table->text('scope')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
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
         Schema::drop('project');
    }
}
