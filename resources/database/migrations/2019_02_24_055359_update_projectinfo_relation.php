<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectinfoRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_info', function (Blueprint $table) 
        {
            $table->json('partner_id')->after('end')->nullable();
            $table->json('role_id')->after('partner_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_info', function (Blueprint $table) {
            $table->dropColumn(['partner_id','role_id']);
        });
    }
}
