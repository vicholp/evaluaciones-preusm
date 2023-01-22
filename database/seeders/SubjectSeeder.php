<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
}
