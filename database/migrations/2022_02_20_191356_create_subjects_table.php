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
                'name' => 'terceros',
                'color' => 'null',
            ],
            [
                'name' => 'matematicas terceros',
                'color' => 'null',
            ],
            [
                'name' => 'lenguaje',
                'color' => 'null',
            ],
            [
                'name' => 'matematicas 1',
                'color' => 'null',
            ],
            [
                'name' => 'matematicas 2',
                'color' => 'null',
            ],
            [
                'name' => 'ciencias fisica',
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
                'name' => 'ciencias quimica',
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
                'name' => 'ciencias biologia',
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
                'name' => 'ciencias biologia TP',
                'color' => 'null',
            ],
            [
                'name' => 'ciencias quimica TP',
                'color' => 'null',
            ],
            [
                'name' => 'ciencias fisica TP',
                'color' => 'null',
            ],
            [
                'name' => 'ciencias TP',
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
