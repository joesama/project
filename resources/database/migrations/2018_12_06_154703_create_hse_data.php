<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHseData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_hse', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('project_hour')->nullable();
            $table->integer('acc_lti')->nullable();
            $table->integer('zero_lti')->nullable();
            $table->integer('unsafe')->nullable();
            $table->integer('stop')->nullable();
            $table->integer('summon')->nullable();
            $table->integer('complaint')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('project', function (Blueprint $table) {
            $table->unsignedInteger('hse_id')->after('client_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_hse');
    }
}
