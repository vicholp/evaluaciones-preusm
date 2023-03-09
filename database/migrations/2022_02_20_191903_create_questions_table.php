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

            $table->boolean('pilot')->default(false);
            $table->integer('position');
            $table->string('name', 100)->nullable();
            $table->string('data', 500)->nullable();

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
