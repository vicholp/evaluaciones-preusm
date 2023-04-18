<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_student', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
            $table->dropForeign(['student_id']);
            $table->dropForeign(['alternative_id']);

            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade');

            $table->foreign('student_id')
                ->references('id')->on('students')
                ->onDelete('cascade');

            $table->foreign('alternative_id')
                ->references('id')->on('alternatives')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_student', function (Blueprint $table) {
            //
        });
    }
};
