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
            $table->foreignId('subject_id')->nullable()->constrained();
            $table->string('color', 500)->nullable();
        });

        DB::table('subjects')->insert([
            [
                'name' => 'terceros',
                'subject_id' => null,
                'color' => null,
            ],
            [
                'name' => 'lenguaje',
                'subject_id' => null,
                'color' => null,
            ],
            [
                'name' => 'matematicas',
                'subject_id' => null,
                'color' => null,
            ],
            [
                'name' => 'ciencias fisica',
                'subject_id' => null,

                'color' => null,
            ],
            [
                'name' => 'ciencias quimica',
                'subject_id' => null,
                'color' => null,
            ],
            [
                'name' => 'ciencias biologia',
                'subject_id' => null,
                'color' => null,
            ],
            [
                'name' => 'historia',
                'subject_id' => null,
                'color' => null,
            ],
            [
                'name' => 'matematicas 1',
                'subject_id' => '3',
                'color' => null,
            ],
            [
                'name' => 'matematicas 2',
                'subject_id' => '3',
                'color' => null,
            ],
            [
                'name' => 'matematicas terceros',
                'subject_id' => '3',
                'color' => null,
            ],
            [
                'name' => 'ciencias fisica comun',
                'subject_id' => '4',
                'color' => null,
            ],
            [
                'name' => 'ciencias fisica electivo',
                'subject_id' => '4',
                'color' => null,
            ],
            [
                'name' => 'ciencias fisica TP',
                'subject_id' => '4',
                'color' => null,
            ],
            [
                'name' => 'ciencias quimica comun',
                'subject_id' => '5',
                'color' => null,
            ],
            [
                'name' => 'ciencias quimica electivo',
                'subject_id' => '5',
                'color' => null,
            ],
            [
                'name' => 'ciencias quimica TP',
                'subject_id' => '5',
                'color' => null,
            ],
            [
                'name' => 'ciencias biologia comun',
                'subject_id' => '6',
                'color' => null,
            ],
            [
                'name' => 'ciencias biologia electivo',
                'subject_id' => '6',
                'color' => null,
            ],
            [
                'name' => 'ciencias biologia TP',
                'subject_id' => '6',
                'color' => null,
            ],
            [
                'name' => 'ciencias TP',
                'subject_id' => null,
                'color' => null,
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
