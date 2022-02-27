<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlternativeStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alternative_student', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('alternative_id')->constrained()->onDelete('cascade');

            $table->unique(['student_id', 'alternative_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alternative_student');
    }
}
