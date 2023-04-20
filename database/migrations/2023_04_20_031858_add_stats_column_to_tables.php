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
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->longText('stats')->nullable();
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->longText('stats')->nullable();
        });

        Schema::table('questionnaire_student', function (Blueprint $table) {
            $table->longText('stats')->nullable();
        });

        Schema::table('question_student', function (Blueprint $table) {
            $table->longText('stats')->nullable();
        });

        Schema::table('students', function (Blueprint $table) {
            $table->longText('stats')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->dropColumn('stats');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('stats');
        });

        Schema::table('questionnaire_student', function (Blueprint $table) {
            $table->dropColumn('stats');
        });

        Schema::table('question_student', function (Blueprint $table) {
            $table->dropColumn('stats');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('stats');
        });
    }
};
