<?php

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
           $table->bigIncrements('company_id');
           $table->string('name', 255);
           $table->timestamps();
           $table->addColumn('tinyInteger', 'status', ['lenght' => 1, 'default' => '1']);
           // $table->tinyInteger('status');
       });
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
