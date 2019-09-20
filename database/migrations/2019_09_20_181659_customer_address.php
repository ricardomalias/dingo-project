<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_address', function (Blueprint $table) {
            $table->uuid('customer_address_id')->primary();
            $table->uuid('customer_id');
            $table->string('zip_code', 10);
            $table->string('address', 255);
            $table->string('number', 255);
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('country', 255);
            $table->timestamps();
            $table->addColumn('tinyInteger', 'status', ['length' => 1, 'default' => '1']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_address');
    }
}
