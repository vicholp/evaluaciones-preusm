<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name', 500)->unique();
            $table->string('color', 500);
        });

        DB::table('subjects')->insert([
            [
                'name' => 'tercero',
                'color' => 'null',
            ],
            [
                'name' => 'lenguaje',
                'color' => 'null',
            ],
            [
                'name' => 'matematicas',
                'color' => 'null',
            ],
            [
                'name' => 'ciencias fisica comun',
                'color' => 'null',
            ],
            [
                'name' => 'ciencias fisica electivo',
                'color' => 'null',
            ],
            [
                'name' => 'ciencias quimica comun',
                'color' => 'null',
            ],
            [
                'name' => 'ciencias quimica electivo',
                'color' => 'null',
            ],
            [
                'name' => 'ciencias biologia comun',
                'color' => 'null',
            ],
            [
                'name' => 'ciencias biologia electivo',
                'color' => 'null',
            ],
            [
                'name' => 'historia',
                'color' => 'null',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
