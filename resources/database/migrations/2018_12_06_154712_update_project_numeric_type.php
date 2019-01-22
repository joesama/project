<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectNumericType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project', function (Blueprint $table) {
            $table->dropColumn(['value', 'gp_propose', 'gp_latest', 'bond']);
        });

        Schema::table('project', function (Blueprint $table) {
            $table->unsignedDecimal('value', 14, 2)->after('name')->nullable();
            $table->unsignedDecimal('gp_propose', 14, 2)->after('value')->nullable();
            $table->unsignedDecimal('gp_latest', 14, 2)->after('gp_propose')->nullable();
            $table->unsignedDecimal('bond', 14, 2)->after('gp_latest')->nullable();
        });

        Schema::table('project_payment', function (Blueprint $table) {
            $table->dropColumn(['claim_amount', 'paid_amount']);
        });

        Schema::table('project_payment', function (Blueprint $table) {
            $table->unsignedDecimal('claim_amount', 14, 2)->after('paid_report_by')->nullable();
            $table->unsignedDecimal('paid_amount', 14, 2)->after('claim_amount')->nullable();
        });

        Schema::table('project_vo', function (Blueprint $table) {
            $table->dropColumn(['amount']);
        });

        Schema::table('project_vo', function (Blueprint $table) {
            $table->unsignedDecimal('amount', 14, 2)->after('report_by')->nullable();
        });

        Schema::table('project_retention', function (Blueprint $table) {
            $table->dropColumn(['amount']);
        });

        Schema::table('project_retention', function (Blueprint $table) {
            $table->unsignedDecimal('amount', 14, 2)->after('report_by')->nullable();
        });

        Schema::table('project_lad', function (Blueprint $table) {
            $table->dropColumn(['amount']);
        });

        Schema::table('project_lad', function (Blueprint $table) {
            $table->unsignedDecimal('amount', 14, 2)->after('report_by')->nullable();
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
