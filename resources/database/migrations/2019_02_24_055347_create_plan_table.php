<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('plan')){
            Schema::create('plan', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->unsignedInteger('project_id')->nullable();
                $table->unsignedInteger('profile_id')->nullable();
                $table->string('name')->nullable();
                $table->text('description')->nullable();
                $table->date('start')->nullable();
                $table->date('end')->nullable();
                $table->float('actual_progress', 8, 2)->default(0)->nullable();
                $table->float('planned_progress', 8, 2)->default(100)->nullable();
                $table->unsignedInteger('status_id')->nullable();
                $table->unsignedInteger('indicator_id')->nullable();
                $table->float('effective_days', 8, 2)->default(0)->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan');
    }
}
