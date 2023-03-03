<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionnairePrototype;
use App\Models\QuestionPrototype;
use App\Models\StatementPrototype;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\TagGroup;
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
        $subjects = Subject::where('name', '!=', 'Lenguaje')->get();
        $tagGroups = TagGroup::get();

        foreach ($subjects as $subject) {
            $prototypes = QuestionPrototype::factory()->for($subject)
                ->hasVersions(rand(1, 5))->count(10)->create();

            foreach ($tagGroups as $tagGroup) {
                foreach ($prototypes as $prototype) {
                    foreach ($prototype->versions as $version) {
                        $tags = Tag::whereTagGroupId($tagGroup->id)->whereSubjectId($subject->id)->get();

                        if ($tags->count() == 0) {
                            $tags = Tag::factory()->for($tagGroup)->for($subject)->count(rand(2, 5))->create();
                        }

                        $version->tags()->attach($tags->random(rand(1, 2)));
                    }
                }
            }

            foreach ($prototypes as $prototype) {
                foreach ($prototype->versions as $version) {
                    $version->implementations()->saveMany(
                        Question::whereQuestionPrototypeVersionId(null)->inRandomOrder()->limit(rand(1, 5))->get()
                    );
                }
            }
        }

        // Creating statements prototypes

        $subjects = Subject::withStatementsQuestions()->get();

        foreach ($subjects as $subject) {
            $statements = StatementPrototype::factory()->forSubject($subject)->count(10)->create();

            foreach ($statements as $statement) {
                $prototypes = QuestionPrototype::factory()->for($subject)
                ->hasVersions(rand(1, 5))->count(10)->create();

                foreach ($prototypes as $prototype) {
                    foreach ($prototype->versions as $version) {
                        foreach($tagGroups as $tagGroup){

                            $tags = Tag::whereTagGroupId($tagGroup->id)->whereSubjectId($subject->id)->get();

                            if ($tags->count() == 0) {
                                $tags = Tag::factory()->for($tagGroup)->for($subject)->count(rand(2, 5))->create();
                            }

                            $version->tags()->attach($tags->random(rand(1, 2)));
                        }
                    }
                }

                $statement->questions()->saveMany(
                    $prototypes
                );
            }
        }

        // Creating questionnaires prototypes for subject with statements

        $subjects = Subject::withStatementsQuestions()->get();

        foreach ($subjects as $subject) {
            $questionnaire = QuestionnairePrototype::factory()->for($subject)->hasVersions(1)->create();

            $position = 1;
            $statementPosition = 1;

            foreach ($subject->statementPrototypes as $statement) {
                if (rand(0, 1)) continue;

                $questionnaire->latest->statements()->attach($statement, [
                    'position' => $position++,
                    'statement_position' => $statementPosition++,
                ]);

                foreach ($statement->questions as $prototype) {
                    if (rand(0, 1)) continue;

                    $questionnaire->latest->questions()->attach($prototype, [
                        'position' => $position++,
                    ]);
                }
            }
        }
    }
}
