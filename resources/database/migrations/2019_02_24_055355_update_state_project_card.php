<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStateProjectCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('project_card', 'state')) {
            Schema::table('project_card', function (Blueprint $table) 
            {
                $table->string('state')->after('month')->nullable();
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
        Schema::table('project_card', function (Blueprint $table) {
            $table->dropColumn(['state']);
        });
    }
}
