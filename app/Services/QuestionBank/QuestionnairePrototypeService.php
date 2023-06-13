<?php

namespace App\Services\QuestionBank;

use App\Models\QuestionnairePrototype;
use App\Models\QuestionnairePrototypeVersion;
use App\Models\QuestionPrototype;
use App\Models\QuestionPrototypeVersion;
use Illuminate\Support\Collection;

/**
 * This class is responsible for managing yhe business logic of the questionnaire prototypes.
 *
 * Note that only the latest version of a questionnaire prototype can be edited, the older versions are read-only.
 */
class QuestionnairePrototypeService
{
    private QuestionnairePrototypeVersion $latest;

    public function __construct(
        private QuestionnairePrototype $questionnairePrototype, // @phpstan-ignore-line
    ) {
        $this->latest = $questionnairePrototype->latest; // @phpstan-ignore-line
    }

    /**
     * Given a collection of questionnaires, create a new questionnaire with all the questions.
     * This preserve the questions positions of the questionnaires.
     *
     * @param Collection<int, QuestionnairePrototype> $questionnaires
     */
    public function createCompilation($questionnaires): void
    {
        //
    }

    /**
     * Create a new version of the questionnaire prototype, with the given questions.
     *
     * @param Collection<int, QuestionPrototypeVersion> $questions
     */
    public function createNewVersion(
        Collection $questions,
        string $name = null,
        string $description = null,
    ): QuestionnairePrototypeVersion {
        $version = $this->questionnairePrototype->versions()->create([
            'name' => $name,
            'description' => $description,
        ]);

        for ($i = 0; $i < $questions->count(); ++$i) {
            $question = $questions[$i];
            $version->questions()->attach($question->id, [ // @phpstan-ignore-line
                'position' => $i,
            ]);
        }

        $this->questionnairePrototype->refresh();

        $this->latest = $this->questionnairePrototype->latest;

        return $version;
    }

    /**
     * Update question version in questionnaire.
     */
    public function updateQuestionInQuestionnaire(
        QuestionPrototype $question,
    ): QuestionnairePrototypeVersion {
        $latest = $question->latest;
        $newQuestions = $this->latest->questions;

        for ($i = 0; $i < $newQuestions->count(); ++$i) {
            if ($newQuestions[$i]->parent->id === $question->id) { // @phpstan-ignore-line
                $newQuestions[$i] = $latest; // @phpstan-ignore-line
            }
        }

        $newVersion = $this->createNewVersion($newQuestions);

        return $newVersion;
    }

    /**
     * Restore the questionnaire to a previous version.
     */
    public function restoreToPreviousVersion(
        QuestionnairePrototypeVersion $newVersion,
    ): void {
        //
    }

    /**
     * Create a new questionnaire with all the questions of the questionnaire prototype.
     *
     * This is intended to be used when a questionnaire prototype is published and applied.
     */
    public function createImplementation(QuestionnairePrototype $questionnaire): void
    {
        //
    }

    /**
     * @return Collection<int, QuestionPrototypeVersion>
     */
    public function getSortedQuestions()
    {
        $latest = $this->latest;
        $questionsSorted = collect();

        $questions = $latest->questions ?? [];

        foreach ($questions as $question) {
            $questionsSorted[$question->pivot->position - 1] = $question; // @phpstan-ignore-line
        }

        return $questionsSorted;
    }
}
