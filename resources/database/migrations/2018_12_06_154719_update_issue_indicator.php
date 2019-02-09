<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIssueIndicator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issue', function (Blueprint $table) {
            $table->unsignedInteger('indicator_id')->after('progress_id')->nullable();
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
