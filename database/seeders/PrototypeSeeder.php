<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionPrototype;
use App\Models\QuestionPrototypeVersion;
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

        foreach ($subjects as $subject) {
            $prototypes = QuestionPrototype::factory()->for($subject)
                ->hasVersions(rand(1, 5))->count(100)->create();

            foreach ($prototypes as $prototype) {
                foreach ($prototype->versions as $version) {
                    if (rand(0, 1)) {
                        continue;
                    }

                    $version->implementations()->saveMany(
                        Question::inRandomOrder()->limit(rand(0, 5))->get()
                    );
                }
            }
        }
    }
}
