<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->timestamps();

            $table->string('name', 500);
            $table->string('email', 255)->unique();
            $table->string('rut', 13)->nullable()->unique();
            $table->string('rut_dv', 1)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 200);
            $table->rememberToken();
        });
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
