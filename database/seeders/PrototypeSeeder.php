<?php

namespace Database\Seeders;

use App\Models\QuestionPrototype;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrototypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = Subject::get();
        QuestionPrototype::factory()->for($subjects->random())->count(10)->hasVersions(5)->create();
    }
}
