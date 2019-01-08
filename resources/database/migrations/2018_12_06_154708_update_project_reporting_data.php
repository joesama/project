<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectReportingData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project', function (Blueprint $table) {
            $table->float('effective_days')->after('planned_progress')->default(0)->nullable();
            $table->float('current_variance', 8, 2)->after('effective_days')->default(0)->nullable();
            $table->float('actual_payment', 8, 2)->after('current_variance')->default(0)->nullable();
            $table->float('planned_payment', 8, 2)->after('actual_payment')->default(0)->nullable();
        });

        Schema::table('task', function (Blueprint $table) {
            $table->float('effective_days', 8, 2)->after('planned_progress')->default(0)->nullable();
        });

        Schema::table('issue', function (Blueprint $table) {
            $table->float('effective_days', 8, 2)->after('active')->default(0)->nullable();
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
