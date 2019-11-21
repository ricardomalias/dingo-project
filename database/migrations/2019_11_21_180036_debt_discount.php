<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DebtDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debt_discount', function (Blueprint $table) {
            $table->uuid('debt_discount_id')->primary();
            $table->string('debt_id', 255);
            $table->date('due_date')->nullable(true);
            $table->enum('type', ['PERCENT', 'MONEY'])->default('PERCENT');
            $table->float('value', 5, 2);
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
        Schema::dropIfExists('debt_discount');
    }
}
