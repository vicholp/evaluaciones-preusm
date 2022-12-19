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
        $students = Student::factory()->count(50)->create();

        $this->call([
            SubjectSeeder::class,
        ]);

        $periods = Period::factory()->count(3)->create();

        $tagGroups = TagGroup::get();

        foreach ($periods as $period) {
            $questionnaireGroups = QuestionnaireGroup::factory()->for($period)->count(5)->create();

            foreach ($questionnaireGroups as $questionnaireGroup) {
                $subjects = Subject::get();
                foreach ($subjects as $subject) {
                    if (!rand(0, 5)) {
                        continue;
                    }

                    $questionnaire = Questionnaire::factory()->for($questionnaireGroup)->for($subject)->create();


                    $tags = [];
                    foreach ($tagGroups as $tagGroup) {
                        array_push($tags, Tag::factory()->for($tagGroup)->count(rand(2, 5))->create());
                    }

                    for ($i = 0; $i < 60; $i += 1) {
                        $question = Question::factory()->for($questionnaire)->state([
                                'name' => $i,
                                'position' => $i,
                                'pilot' => !rand(0, 100)
                            ])->create();

                        foreach ($tags as $tag) {
                            $question->tags()->attach($tag->random());
                        }

                        $this->addAlternativesToQuestion($question);
                    }




                    $questionnaire->load('questions', 'questions.alternatives');

                    foreach ($students as $student) {
                        if (rand(0, 1)) {
                            foreach ($questionnaire->questions as $question) {
                                $student->attachAlternative($question->alternatives[rand(0, 4)]);
                            }
                        }
                    }

                    dump('questionnaire '.$questionnaire->id);
                }
                dump('questionnaire group '.$questionnaireGroup->id);
            }
            dump('period'. $period->id);
        }
    }

    private function addAlternativesToQuestion(Question $question)
    {
        Alternative::create(['name' => 'A', 'question_id' => $question->id, 'position' => 1,
            'correct' => false]);
        Alternative::create(['name' => 'B', 'question_id' => $question->id, 'position' => 2,
            'correct' => false]);
        Alternative::create(['name' => 'C', 'question_id' => $question->id, 'position' => 3,
            'correct' => false]);
        Alternative::create(['name' => 'D', 'question_id' => $question->id, 'position' => 4,
            'correct' => false]);
        Alternative::create(['name' => 'E', 'question_id' => $question->id, 'position' => 5,
            'correct' => false]);

        $question->alternatives->random()->update(['correct' => true]);
    }
}
