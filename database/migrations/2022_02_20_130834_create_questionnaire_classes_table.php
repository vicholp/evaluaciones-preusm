<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateQuestionnaireClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_classes', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('description')->nullable();

            $table->timestamps();
        });

        DB::table('questionnaire_classes')->insert([
            'name' => 'Ensayo General',
        ]);

        DB::table('questionnaire_classes')->insert([
            'name' => 'Ensayo Parcial',
        ]);

        DB::table('questionnaire_classes')->insert([
            'name' => 'Ensayo Masivo',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionnaire_classes');
    }
}
