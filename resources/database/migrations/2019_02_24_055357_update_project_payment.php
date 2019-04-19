<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('project_payment', 'client_id')) {
            Schema::table('project_payment', function (Blueprint $table) 
            {
                $table->unsignedInteger('client_id')->after('card_id')->nullable();            
            });
        }

        if (!Schema::hasColumn('project_lad', 'client_id')) {
            Schema::table('project_lad', function (Blueprint $table) 
            {
                $table->unsignedInteger('client_id')->after('amount')->nullable();            
            });
        }

        if (!Schema::hasColumn('project_lad', 'card_id')) {
            Schema::table('project_lad', function (Blueprint $table) 
            {
                $table->unsignedInteger('report_id')->after('client_id')->nullable();            
                $table->unsignedInteger('card_id')->after('report_id')->nullable();            
            });
        }

        if (!Schema::hasColumn('project_retention', 'client_id')) {
            Schema::table('project_retention', function (Blueprint $table) 
            {
                $table->unsignedInteger('client_id')->after('amount')->nullable();            
            });
        }

        if (!Schema::hasColumn('project_retention', 'card_id')) {
            Schema::table('project_retention', function (Blueprint $table) 
            {
                $table->unsignedInteger('report_id')->after('client_id')->nullable();            
                $table->unsignedInteger('card_id')->after('report_id')->nullable();            
            });
        }

        if (!Schema::hasColumn('project_vo', 'client_id')) {
            Schema::table('project_vo', function (Blueprint $table) 
            {
                $table->unsignedInteger('client_id')->after('amount')->nullable();            
            });
        }

        if (!Schema::hasColumn('project_vo', 'card_id')) {
            Schema::table('project_vo', function (Blueprint $table) 
            {
                $table->unsignedInteger('report_id')->after('client_id')->nullable();            
                $table->unsignedInteger('card_id')->after('report_id')->nullable();             
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
        Schema::table('project_payment', function (Blueprint $table) {
            $table->dropColumn(['client_id']);
        });
        
        Schema::table('project_lad', function (Blueprint $table) {
            $table->dropColumn(['client_id']);
        });

        Schema::table('project_retention', function (Blueprint $table) {
            $table->dropColumn(['client_id']);
        });

        Schema::table('project_vo', function (Blueprint $table) {
            $table->dropColumn(['client_id']);
        });
    }
}
