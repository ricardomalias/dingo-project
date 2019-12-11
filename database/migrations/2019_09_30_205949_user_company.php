<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_company', function (Blueprint $table) {
            $table->uuid('user_company_id')->primary();
            $table->uuid('user_id');
            $table->uuid('company_id');
            $table->timestamps();
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1']);
        });

        // Insert data
        DB::table('user_company')->insert(
            array(
                'user_company_id' => 'ebb1e4d8-f732-4a0a-9358-2724e6f923a8',
                'user_id' => '99a88809-0317-4691-9301-dcf99cb8c0a1',
                'company_id' => '9036ff76-336e-4c64-9a97-584d2302abc0',
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
        Schema::dropIfExists('user_company');
    }
}
