<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePortfolioData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project', function (Blueprint $table) {
            $table->float('actual_progress', 8, 2)->after('end')->default(0)->nullable();
            $table->float('planned_progress', 8, 2)->after('actual_progress')->default(100)->nullable();
        });

        Schema::table('task', function (Blueprint $table) {
            $table->float('actual_progress', 8, 2)->after('end')->default(0)->nullable();
            $table->float('planned_progress', 8, 2)->after('actual_progress')->default(100)->nullable();
        });

        Schema::table('issue', function (Blueprint $table) {
            $table->unsignedInteger('active')->after('progress_id')->default(1)->nullable();
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
