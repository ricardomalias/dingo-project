<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DebtNegotiation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debt_negotiation', function (Blueprint $table) {
            $table->uuid('debt_negotiation_id');
            $table->uuid('debt_id');
            $table->float('amount', 10, 2);
            $table->integer('parcel_quantity');
            $table->string('payment_method', 255);
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
        Schema::dropIfExists('debt_negotiation');
    }
}
