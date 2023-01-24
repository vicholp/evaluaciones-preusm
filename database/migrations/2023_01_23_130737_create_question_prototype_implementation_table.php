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
        Schema::create('question_prototype_implementation', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('question_prototype_version_id');
            $table->unsignedBigInteger('question_id');

            $table->foreign('question_prototype_version_id', 'question_prototype_version_id_foreign')->references('id')->on('question_prototype_versions')->cascadeOnDelete();
            $table->foreign('question_id', 'question_id_foreign')->references('id')->on('questions')->cascadeOnDelete();

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
        Schema::dropIfExists('question_prototype_implementation');
    }
};
