<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_student', function (Blueprint $table) {
            $table->id();

            $table->foreignId('question_id')->constrained();
            $table->foreignId('student_id')->constrained();

            $table->foreignId('alternative_id')->constrained();

            $table->integer('score')->nullable();

            $table->unique(['question_id', 'student_id']);

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
        Schema::dropIfExists('question_student');
    }
}
