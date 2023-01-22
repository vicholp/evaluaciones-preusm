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
        Schema::create('question_prototype_versions', function (Blueprint $table) {
            $table->id();

            $table->mediumText('name');
            $table->longText('description')->nullable();
            $table->longText('body');

            $table->foreignId('question_prototype_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('question_prototype_versions');
    }
};
