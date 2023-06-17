<?php

namespace App\Services\Results;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\QuestionnairePrototypeVersion;
use Illuminate\Support\Collection;

class QuestionnaireService
{
    public function __construct(
        private Questionnaire $questionnaire,
    ) {
        //
    }

    public static function create(
        ?string $name,
        int $questionnaireGroupId,
        int $subjectId,
        int $questionCount,
    ): Questionnaire {
        $questionnaire = Questionnaire::create([
            'name' => $name,
            'questionnaire_group_id' => $questionnaireGroupId,
            'subject_id' => $subjectId,
        ]);

        $service = new self($questionnaire);

        $service->createQuestionsWithAlternatives($questionCount);

        return $questionnaire;
    }

    public static function createFromPrototype(
        ?string $name,
        QuestionnaireGroup $questionnaireGroup,
        QuestionnairePrototypeVersion $questionnairePrototypeVersion,
    ): Questionnaire {
        $questionnaire = Questionnaire::create([
            'name' => $name ?? $questionnairePrototypeVersion->name ?? null,
            'questionnaire_group_id' => $questionnaireGroup->id,
            'subject_id' => $questionnairePrototypeVersion->parent->subject->id,
            'questionnaire_prototype_version_id' => $questionnairePrototypeVersion->id,
        ]);

        $questions = $questionnairePrototypeVersion->questions;

        for ($i = 0; $i < $questions->count(); ++$i) {
            $questionPrototypeVersion = $questionnairePrototypeVersion->questions[$i];

            QuestionService::createFromPrototype(
                $questionPrototypeVersion?->id, // @phpstan-ignore-line
                $i + 1,
                $questionnaire->id,
            );
        }

        return $questionnaire;
    }

    /**
     * @return Collection<int, Question>
     */
    public function createQuestionsWithAlternatives(int $count)
    {
        $questions = collect();

        for ($i = 0; $i < $count; ++$i) {
            $question = QuestionService::createWithAlternatives($i + 1, $this->questionnaire->id); // @phpstan-ignore-line

            $questions->push($question);
        }

        return $questions;
    }
}
