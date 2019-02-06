<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectApprovalState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_approval', function (Blueprint $table) {
            $table->string('state')->after('approve_date')->nullable();
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
