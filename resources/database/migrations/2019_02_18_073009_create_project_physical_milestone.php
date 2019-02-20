<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectPhysicalMilestone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('project_milestone_physical');

        Schema::create('project_milestone_physical', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('project_id')->nullable()->comment('Project This Milestone Attached');
            $table->unsignedInteger('card_id')->nullable()->comment('Monthly Report This Milestone Attached');
            $table->string('label')->nullable()->comment('Month & Year Description');
            $table->date('progress_date')->nullable()->comment('Date When The Progress Locked. End Of the Month Date');
            $table->unsignedDecimal('planned', 8, 2)->nullable()->comment('Planned Value');
            $table->unsignedDecimal('actual', 8, 2)->nullable()->comment('Actual Value');
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
        Schema::drop('project_milestone_physical');
    }
}
