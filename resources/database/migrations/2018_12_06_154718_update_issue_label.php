<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIssueLabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issue', function (Blueprint $table) {
            $table->string('label')->after('progress_id')->nullable();
            $table->text('description')->nullable()->change();
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
