<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_document', function (Blueprint $table) {
            $table->uuid('customer_document_id')->primary();
            $table->uuid('customer_id');
            $table->string('type', 255);
            $table->string('value', 255);
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
        Schema::dropIfExists('customer_document');
    }
}
