<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompanyConfiguration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_configuration', function (Blueprint $table) {
            $table->uuid('company_configuration_id')->primary();
            $table->uuid('company_id');
            $table->string('key', 255);
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
        Schema::dropIfExists('company_configuration');
    }
}
