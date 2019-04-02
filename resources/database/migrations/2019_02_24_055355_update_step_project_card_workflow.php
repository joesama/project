<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStepProjectCardWorkflow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('project_card_workflow', 'step_id')) {
            Schema::table('project_card_workflow', function (Blueprint $table) 
            {
                $table->unsignedInteger('step_id')->after('state')->nullable();
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
        Schema::table('project_card_workflow', function (Blueprint $table) {
            $table->dropColumn(['step_id']);
        });
    }
}
