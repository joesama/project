<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePlanReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('plan', 'card_id') && !Schema::hasColumn('plan', 'report_id')) {
            Schema::table('plan', function (Blueprint $table) 
            {
                $table->unsignedInteger('report_id')->after('effective_days')->nullable();
                $table->unsignedInteger('card_id')->after('report_id')->nullable();
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
        Schema::table('plan', function (Blueprint $table) {
            $table->dropColumn(['report_id','card_id']);
        });
    }
}
