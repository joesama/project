<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTaskIndicatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task', function (Blueprint $table) {
            if (!Schema::hasColumn('task','indicator_id')) {
                $table->unsignedInteger('indicator_id')->after('status_id')->nullable();
            }
            if (!Schema::hasColumn('task','description')) {
                $table->text('description')->after('indicator_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
