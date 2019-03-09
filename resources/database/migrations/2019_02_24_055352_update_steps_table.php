<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('process_step', 'status_id') && !Schema::hasColumn('process_step', 'role_id')) {
            Schema::table('process_step', function (Blueprint $table) 
            {
                $table->unsignedInteger('status_id')->nullable();

                $table->unsignedInteger('role_id')->nullable();
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

    }
}
