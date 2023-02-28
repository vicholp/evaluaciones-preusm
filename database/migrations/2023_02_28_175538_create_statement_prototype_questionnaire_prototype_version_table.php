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
        Schema::create('questionnaire_prototype_version_statement_prototype', function (Blueprint $table) {
            $table->id();

            $table->integer('position');
            $table->integer('statement_position');

            $table->unsignedBigInteger('questionnaire_prototype_version_id');
            $table->unsignedBigInteger('statement_prototype_id');

            $table->foreign('questionnaire_prototype_version_id', 'questionnaire_statement_prototype_id_foreign')->references('id')->on('questionnaire_prototype_versions')->cascadeOnDelete();
            $table->foreign('statement_prototype_id', 'statement_questionnaire_prototype_versions_id_foreign')->references('id')->on('statement_prototypes')->cascadeOnDelete();

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
