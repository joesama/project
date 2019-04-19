<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateHseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rawpath = base_path('vendor/joesama/project/resources/database/raw/hse.json');

        $hseConfig = collect(json_decode(file_get_contents($rawpath), true));

        $masterCode = $hseConfig->pluck('master_code');

        Schema::table('project_hse', function (Blueprint $table) use ($masterCode){
            $table->dropColumn(['acc_lti', 'zero_lti', 'unsafe','stop','summon','complaint']);

            $masterCode->sortKeysDesc()->each(function($code) use($table) {
                $table->string(strtolower($code))->after('project_hour')->nullable();
            });
        });

        Schema::table('project_incident', function (Blueprint $table){
            $table->string('incident_code')->after('incident_id')->nullable();
            $table->date('incident_date')->after('incident_code')->nullable();
            $table->string('sub_code')->after('incident_date')->nullable();
            $table->unsignedInteger('report_id')->after('sub_code')->nullable();
            $table->unsignedInteger('card_id')->after('report_id')->nullable();
        });
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
