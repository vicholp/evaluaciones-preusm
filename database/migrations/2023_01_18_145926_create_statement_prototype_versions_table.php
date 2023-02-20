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
        Schema::create('statement_prototype_versions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('statement_prototype_id')->constrained()->cascadeOnDelete();

            $table->mediumText('name')->nullable();
            $table->longText('description')->nullable();
            $table->longText('body');

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
        Schema::dropIfExists('statement_prototype_versions');
    }
};
