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
        Schema::create('questionnaire_import_answers_results', function (Blueprint $table) {
            $table->id();

            $table->foreignId('root_questionnaire_import_answers_result_id')->nullable();
            $table->foreignId('parent_questionnaire_import_answers_result_id')->nullable();
            $table->foreignId('questionnaire_id')->constrained();
            $table->foreignId('student_id')->nullable()->constrained();
            $table->foreignId('alternative_id')->nullable()->constrained();
            $table->foreignId('question_id')->nullable()->constrained();
            $table->foreignId('admin_id')->nullable()->contrained();

            $table->json('data')->nullable();
            $table->json('log')->nullable();
            $table->string('result')->nullable();

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
        Schema::dropIfExists('questionnaire_import_answers_results');
    }
};
