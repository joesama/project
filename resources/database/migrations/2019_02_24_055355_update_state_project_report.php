<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStateProjectReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('project_report', 'state')) {
            Schema::table('project_report', function (Blueprint $table) 
            {
                $table->string('state')->after('week')->nullable();
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
        Schema::table('project_report', function (Blueprint $table) {
            $table->dropColumn(['state']);
        });
    }
}
