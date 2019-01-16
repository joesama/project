<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateReportNeedActionData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('project_report', function (Blueprint $table) {
            $table->unsignedInteger('need_action')->after('workflow_id')->nullable();
        });
        
        Schema::table('project_card', function (Blueprint $table) {
            $table->unsignedInteger('need_action')->after('workflow_id')->nullable();
        });

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
