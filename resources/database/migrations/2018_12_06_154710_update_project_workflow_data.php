<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectWorkflowData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('profile', function (Blueprint $table) {
        //     $table->unsignedInteger('position_id')->after('corporate_id')->nullable();
        // });
        
        // Schema::table('project_report', function (Blueprint $table) {
        //     $table->unsignedInteger('creator_id')->after('workflow_id')->nullable();
        //     $table->unsignedInteger('week')->after('creator_id')->nullable();
        //     $table->date('report_end')->after('report_date')->nullable();
        // });
        
        // Schema::table('project_card', function (Blueprint $table) {
        //     $table->unsignedInteger('month')->after('creator_id')->nullable();
        //     $table->date('card_end')->after('card_date')->nullable();
        // });

        Schema::table('project_report_workflow', function (Blueprint $table) {
            $table->renameColumn('user_id', 'profile_id');
            $table->string('state')->after('profile_id')->nullable();
        });

        // Schema::table('project_card_workflow', function (Blueprint $table) {
        //     $table->string('state')->after('profile_id')->nullable();
        // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    
    }
}
