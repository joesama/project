<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMasterData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $found = DB::table('master')->where('id',8)->first();
        if(!$found){
            DB::table('master')->insert(
                array(
                    'id' => 8,
                    'description' => 'task'
                )
            );
        }
        $found = DB::table('master_data')->where('master_id',8)->first();
        if(!$found){
            DB::table('master_data')->insert(array(
                array(
                    'master_id' => 8,
                    'description' => 'Not Started'
                ),
                array(
                    'master_id' => 8,
                    'description' => 'In Progress'
                ),
                array(
                    'master_id' => 8,
                    'description' => 'Completed'
                )
            ));
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
