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
                'name' => 'fisica',
                'color' => 'null',
            ],
            [
                'name' => 'quimica',
                'color' => 'null',
            ],
            [
                'name' => 'biologia',
                'color' => 'null',
            ],
            [
                'name' => 'historia',
                'color' => 'null',
            ],
        ]);
    }
}
