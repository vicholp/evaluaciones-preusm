<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name', 500);
            $table->boolean('pilot')->default(false);
            $table->foreignId('subject_id')->constrained();
            $table->foreignId('questionnaire_group_id')->constrained();

            $table->float('average')->nullable();
            $table->float('standart_deviation')->nullable();
            $table->float('skewness')->nullable();
            $table->float('kurtosis')->nullable();
            $table->float('coefficient_internal_consistency')->nullable();
            $table->float('error_ratio')->nullable();
            $table->float('standard_error')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionnaires');
    }
}
