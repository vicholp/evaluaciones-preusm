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
        Schema::create('question_prototype_version_tag', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tag_id')->constrained();
            $table->unsignedBigInteger('question_prototype_version_id');
            $table->foreign('question_prototype_version_id', 'question_prototype_version_fk')->references('id')->on('question_prototype_versions')->cascadeOnDelete();

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
        Schema::dropIfExists('tag_question_prototype');
    }
};
