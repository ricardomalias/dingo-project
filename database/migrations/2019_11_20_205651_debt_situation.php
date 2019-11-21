<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DebtSituation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debt_situation', function (Blueprint $table) {
            $table->uuid('debt_situation_id')->primary();
            $table->string('debt_id', 255);
            $table->enum('situation', ['PENDING', 'ACCEPTED', 'EXPIRED'])->default('PENDING');
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
        Schema::dropIfExists('debt_situation');
    }
}
