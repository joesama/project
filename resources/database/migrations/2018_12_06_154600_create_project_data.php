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
            $table->unsignedInteger('client_id')->nullable();
            $table->unsignedInteger('corporate_id')->nullable();
            $table->string('name')->nullable();
            $table->string('value')->nullable();
            $table->string('contract')->nullable();
            $table->string('gp_propose')->nullable();
            $table->string('gp_latest')->nullable();
            $table->float('bond', 8, 2)->nullable();
            $table->text('scope')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->unsignedInteger('active')->default(1)->nullable();
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
