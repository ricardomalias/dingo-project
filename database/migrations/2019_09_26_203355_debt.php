<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Debt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debt', function (Blueprint $table) {
            $table->uuid('debt_id')->primary();
            $table->string('company_id', 255);
            $table->float('amount', 10);
            $table->integer('parcel_quantity', 0);
            $table->date('due_date');
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
        Schema::dropIfExists('debt');
    }
}
