<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('questionnaire_id')->constrained()->onDelete('cascade');
            $table->integer('position');
            $table->string('name', 100);
            $table->string('data', 500)->nullable();

            $table->float('facility_index')->nullable();
            $table->float('standart_deviation')->nullable();
            $table->float('random_guess_score')->nullable();
            $table->float('intended_weight')->nullable();
            $table->float('effective_weight')->nullable();
            $table->float('discrimination_index')->nullable();
            $table->float('discrimination_efficiency')->nullable();

            $table->unique(['questionnaire_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
