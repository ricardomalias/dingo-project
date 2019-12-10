<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('user_id')->primary();
//            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Insert some stuff
        DB::table('users')->insert(
            array(
                'user_id' => '99a88809-0317-4691-9301-dcf99cb8c0a1',
                'name' => 'Anderson Marin',
                'email' => 'anderson.marin@talkip.com.br',
                'password' => '$2y$10$2lYQdbU83MOfVEbCH3TcAulEZ08OzU0ndhI6WPz5nJeiP2LZUwPqK',
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
        Schema::dropIfExists('users');
    }
}
