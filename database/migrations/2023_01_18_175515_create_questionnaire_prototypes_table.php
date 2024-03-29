<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_prototypes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subject_id')->constrained();

            $table->enum('questions_type', ['simple', 'grouped', 'mixed'])->default('simple');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionnaire_prototypes');
    }
};
