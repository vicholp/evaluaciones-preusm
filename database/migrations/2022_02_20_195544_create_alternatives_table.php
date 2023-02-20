<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlternativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alternatives', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->integer('position');
            $table->string('name', 5);
            $table->string('data', 500)->nullable();
            $table->boolean('correct');

            $table->unique(['question_id', 'position']);
            $table->unique(['question_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alternatives');
    }
}
