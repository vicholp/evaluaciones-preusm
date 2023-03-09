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
        Schema::create('questionnaire_prototype_versions', function (Blueprint $table) {
            $table->id();

            $table->mediumText('name')->nullable();
            $table->longText('description')->nullable();

            $table->unsignedBigInteger('questionnaire_prototype_id');

            $table->foreign('questionnaire_prototype_id', 'questionnaire_prototype_version_id_foreign')->references('id')->on('questionnaire_prototypes')->cascadeOnDelete();

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
        Schema::dropIfExists('questionnaire_prototype_versions');
    }
};
