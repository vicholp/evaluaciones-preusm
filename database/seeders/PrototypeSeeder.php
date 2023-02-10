<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionPrototype;
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
        $subjects = Subject::get();
        $tagGroups = TagGroup::get();

        foreach ($subjects as $subject) {
            $prototypes = QuestionPrototype::factory()->for($subject)
                ->hasVersions(rand(1, 5))->count(10)->create();

            foreach($tagGroups as $tagGroup) {
                foreach($prototypes as $prototype) {
                    foreach($prototype->versions as $version) {
                        $tags = Tag::whereTagGroupId($tagGroup->id)->whereSubjectId($subject->id)->get();

                        if($tags->count() == 0) {
                            $tags = Tag::factory()->for($tagGroup)->for($subject)->count(rand(2, 5))->create();
                        }

                        $version->tags()->attach($tags->random(rand(1,2)));
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
    }
}
