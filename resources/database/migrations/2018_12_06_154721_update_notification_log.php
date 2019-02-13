<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNotificationLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification_log', function (Blueprint $table) {
            $table->renameColumn('notifiable','notifiable_type');
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
