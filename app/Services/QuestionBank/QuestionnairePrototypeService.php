<?php

namespace App\Services\QuestionBank;

use App\Models\Question;
use App\Models\QuestionnairePrototype;
use App\Models\QuestionnairePrototypeVersion;
use App\Models\QuestionPrototype;
use App\Models\QuestionPrototypeVersion;
use App\Models\StatementPrototype;
use App\Models\Subject;
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
        private QuestionnairePrototype $questionnairePrototype,
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
     * Get the position of the last item in the questionnaire.
     * It can be a question or a statement.
     */
    public function lastPosition(): int
    {
        return $this->latest->questions()->count() + $this->latest->statements()->count();
    }

    /**
     * True if the questionnaire has at least one statement attached.
     */
    public function hasStatements(): bool
    {
        return $this->latest->statements()->count() > 0;
    }

    public function getLastStatement(): StatementPrototype
    {
        return $this->latest->statements()->orderBy('position', 'desc')->first();
    }

    /**
     * Attach a question to the end of the questionnaire.
     */
    public function attachQuestion(QuestionPrototypeVersion $question): QuestionnairePrototypeVersion
    {
        $this->latest->questions()->attach($question->id, [
            'position' => $this->lastPosition() + 1,
        ]);

        $this->questionnairePrototype->refresh();

        return $this->questionnairePrototype->latest; // @phpstan-ignore-line
    }

    /**
     * Attach a statement to the end of the questionnaire.
     */
    public function attachStatement(StatementPrototype $statement): QuestionnairePrototype
    {
        $this->latest->statements()->attach($statement->id, [
            'position' => $this->lastPosition() + 1,
            'statement_position' => 0,
        ]);

        $this->questionnairePrototype->refresh();

        return $this->questionnairePrototype;
    }

    public static function create(
        ?string $name,
        ?string $description,
        Subject $subject,
    ): QuestionnairePrototype {
        $questionnaire = QuestionnairePrototype::create([
            'subject_id' => $subject->id,
        ]);

        $questionnaire->versions()->create([
            'name' => $name,
            'description' => $description,
        ]);

        $questionnaire->refresh();

        return $questionnaire;
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
                'position' => $i + 1,
            ]);
        }

        $this->questionnairePrototype->refresh();

        $this->latest = $this->questionnairePrototype->latest; // @phpstan-ignore-line

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
}
