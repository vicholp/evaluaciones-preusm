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
        Schema::create('question_prototype_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('question_prototype_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_prototype_version_id')->constrained()->cascadeOnDelete();

            $table->unique(['question_prototype_id', 'user_id', 'question_prototype_version_id'], 'question_prototype_review_unique');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_prototype_reviews');
    }
};
