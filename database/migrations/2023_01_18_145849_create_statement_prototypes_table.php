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
        Schema::create('statement_prototypes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subject_id')->constrained();

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
        Schema::dropIfExists('statement_prototypes');
    }
};
