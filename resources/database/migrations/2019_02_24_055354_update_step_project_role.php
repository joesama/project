<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStepProjectRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('project_role', 'step_id')) {
            Schema::table('project_role', function (Blueprint $table) 
            {
                $table->unsignedInteger('step_id')->after('role_id')->nullable();
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
        Schema::table('project_role', function (Blueprint $table) {
            $table->dropColumn(['step_id']);
        });
    }
}
