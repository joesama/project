<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectJobCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project', function (Blueprint $table) {
            $table->string('job_code')->after('contract')->nullable();
        });
    }

    /**
     * Reverse the migrations4.
     *
     * @return void
     */
    public function down()
    {

    }
}
