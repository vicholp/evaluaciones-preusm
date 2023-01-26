<?php

namespace Database\Seeders;

use App\Models\Alternative;
use App\Models\Period;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\TagGroup;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SubjectSeeder::class,
            QuestionnaireSeeder::class,
            PrototypeSeeder::class,
        ]);
    }
}
