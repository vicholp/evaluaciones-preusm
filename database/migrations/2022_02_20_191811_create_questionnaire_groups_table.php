<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_groups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name', 500)->nullable();
            $table->foreignId('period_id')->constrained();
            $table->foreignId('questionnaire_class_id')->constrained();
            $table->integer('position');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->unique(['period_id', 'questionnaire_class_id', 'position'], 'questionnaire_groups_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionnaire_groups');
    }
}
