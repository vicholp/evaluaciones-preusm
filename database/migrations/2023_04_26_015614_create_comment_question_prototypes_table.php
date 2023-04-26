<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comment_question_prototypes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('question_prototype_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->unsignedBigInteger('question_prototype_version_id');

            $table->foreign('question_prototype_version_id', 'question_prototype_version_id_foreign')
                ->references('id')->on('question_prototype_versions')->cascadeOnDelete();

            $table->text('content');
            $table->enum('type', ['comment', 'action'])->default('comment');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_question_prototypes');
    }
};
