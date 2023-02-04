<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_prototype_version_questionnaire_prototype_version', function (Blueprint $table) {
            $table->id();

            $table->integer('position');

            $table->unsignedBigInteger('questionnaire_prototype_version_id');
            $table->unsignedBigInteger('question_prototype_version_id');

            $table->foreign('questionnaire_prototype_version_id', 'questionnaire_question_prototype_version_id_foreign')->references('id')->on('questionnaire_prototype_versions')->cascadeOnDelete();
            $table->foreign('question_prototype_version_id', 'question_questionnaire_prototype_versions_id_foreign')->references('id')->on('question_prototype_versions')->cascadeOnDelete();

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
        Schema::dropIfExists('questionnaire_question_prototypes');
    }
};
