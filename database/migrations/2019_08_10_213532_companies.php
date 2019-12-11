<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Companies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
           $table->uuid('company_id')->primary();
           $table->string('name', 255);
           $table->timestamps();
           $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1']);
       });

        // Insert data
        DB::table('company')->insert(
            array(
                'company_id' => '9036ff76-336e-4c64-9a97-584d2302abc0',
                'name' => 'Fuxirico Corporation LTDA',
                'created_at' => '2019-12-11',
                'updated_at' => '2019-12-11',
                'status' => 1
            )
        );
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
