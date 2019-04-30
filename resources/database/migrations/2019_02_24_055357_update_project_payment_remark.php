<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectPaymentRemark extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('project_payment', 'remark_claim')) {
            Schema::table('project_payment', function (Blueprint $table) 
            {
                $table->text('remark_claim')->after('client_id')->nullable();            
            });
        }

        if (!Schema::hasColumn('project_payment', 'remark_payment')) {
            Schema::table('project_payment', function (Blueprint $table) 
            {
                $table->text('remark_payment')->after('remark_claim')->nullable();            
            });
        }

        if (!Schema::hasColumn('project_lad', 'remark')) {
            Schema::table('project_lad', function (Blueprint $table) 
            {
                $table->text('remark')->after('client_id')->nullable();            
            });
        }


        if (!Schema::hasColumn('project_retention', 'remark')) {
            Schema::table('project_retention', function (Blueprint $table) 
            {
                $table->text('remark')->after('client_id')->nullable();            
            });
        }


        if (!Schema::hasColumn('project_vo', 'remark')) {
            Schema::table('project_vo', function (Blueprint $table) 
            {
                $table->text('remark')->after('client_id')->nullable();            
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
            $table->dropColumn(['remark_claim','remark_payment']);
        });
        
        Schema::table('project_lad', function (Blueprint $table) {
            $table->dropColumn(['remark']);
        });

        Schema::table('project_retention', function (Blueprint $table) {
            $table->dropColumn(['remark']);
        });

        Schema::table('project_vo', function (Blueprint $table) {
            $table->dropColumn(['remark']);
        });
    }
}
