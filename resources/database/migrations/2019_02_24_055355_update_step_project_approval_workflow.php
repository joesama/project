<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStepProjectApprovalWorkflow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('project_approval_workflow', 'step_id')) {
            Schema::table('project_approval_workflow', function (Blueprint $table) 
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
        Schema::table('project_approval_workflow', function (Blueprint $table) {
            $table->dropColumn(['step_id']);
        });
    }
}
