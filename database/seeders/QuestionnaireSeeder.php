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

class QuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $STUDENT_COUNT = 5;
        $PERIOD_COUNT = 1;
        $QUESTIONNAIRE_GROUP_COUNT = 1;
        $QUESTIONNAIRE_PROBABILITY = 1;
        $QUESTIONNAIRE_MAX_COUNT = 10;
        $QUESTION_COUNT = 60;

        $students = Student::factory()->count($STUDENT_COUNT)->create();

        $periods = Period::factory()->count($PERIOD_COUNT)->create();

        $tagGroups = TagGroup::get();

        $subjects = Subject::forQuestionnaires()->get();

        $bar = $this->command->getOutput()->createProgressBar();

        $bar->start();

        foreach ($subjects as $subject) {
            foreach ($tagGroups as $tagGroup) {
                Tag::factory()->for($tagGroup)->for($subject)->count(15)->create();
            }
        }

        foreach ($periods as $period) {
            $questionnaireGroups = QuestionnaireGroup::factory()->for($period)->count($QUESTIONNAIRE_GROUP_COUNT)->create();

            foreach ($questionnaireGroups as $questionnaireGroup) {
                $questionnaire_count = 0;

                foreach ($subjects as $subject) {
                    if ($questionnaire_count >= $QUESTIONNAIRE_MAX_COUNT) {
                        break;
                    }

                    if (!$QUESTIONNAIRE_PROBABILITY) {
                        continue;
                    }

                    ++$questionnaire_count;

                    $questionnaire = Questionnaire::factory()->for($questionnaireGroup)->for($subject)->create();

                    $tags = [];
                    foreach ($tagGroups as $tagGroup) {
                        if (rand(0, 10)) {
                            array_push($tags, Tag::whereTagGroupId($tagGroup->id)->whereSubjectId($subject->id)->get());
                        } else {
                            array_push($tags, Tag::factory()->for($tagGroup)->for($subject)->count(rand(2, 10))->create());
                        }
                    }

                    for ($i = 0; $i < $QUESTION_COUNT; ++$i) {
                        $question = Question::factory()->for($questionnaire)->state([
                                'name' => $i,
                                'position' => $i,
                                'pilot' => !rand(0, 100),
                            ])->create();

                        foreach ($tags as $tag) {
                            $question->tags()->attach($tag->random(rand(0, 1)));
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
                        $bar->advance();
                    }
                }
            }
        }
        $bar->finish();
        $this->command->newLine();
    }

    private function addAlternativesToQuestion(Question $question)
    {
        Alternative::create(['name' => 'A', 'question_id' => $question->id, 'position' => 1,
            'correct' => false, ]);
        Alternative::create(['name' => 'B', 'question_id' => $question->id, 'position' => 2,
            'correct' => false, ]);
        Alternative::create(['name' => 'C', 'question_id' => $question->id, 'position' => 3,
            'correct' => false, ]);
        Alternative::create(['name' => 'D', 'question_id' => $question->id, 'position' => 4,
            'correct' => false, ]);
        Alternative::create(['name' => 'E', 'question_id' => $question->id, 'position' => 5,
            'correct' => false, ]);

        $question->alternatives->random()->update(['correct' => true]);

        Alternative::create(['name' => 'N/A', 'question_id' => $question->id, 'position' => 0,
            'correct' => false, ]);
    }
}
