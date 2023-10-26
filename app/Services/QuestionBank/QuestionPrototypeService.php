<?php

namespace App\Services\QuestionBank;

use App\Models\QuestionnairePrototype;
use App\Models\QuestionPrototype;
use App\Models\QuestionPrototypeVersion;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\TagGroup;
use Illuminate\Support\Collection;

class QuestionPrototypeService
{
    private QuestionPrototypeVersion $latest;

    public function __construct(
        private QuestionPrototype $questionPrototype,
    ) {
        if (!$questionPrototype->latest) {
            throw new \Exception('Question prototype does not have a version');
        }
        $this->latest = $questionPrototype->latest;
    }

    /**
     * Create a new question and a attach a version to it.
     *
     * @param Collection<int, Tag> $tags
     */
    public static function create(
        Subject $subject,
        ?string $name,
        ?string $description,
        string $body,
        string $answer,
        ?string $solution,
        ?Collection $tags,
    ): QuestionPrototypeVersion {
        $question = QuestionPrototype::create([
            'subject_id' => $subject->id,
            ]);

        $version = $question->versions()->create([
            'name' => $name,
            'description' => $description,
            'body' => $body,
            'answer' => $answer,
            'solution' => $solution,
        ]);

        if ($tags) {
            $version->tags()->attach($tags);
        }

        return $version;
    }

    /**
     * Create a new version for the existing question.
     *
     * @param Collection<int, Tag> $tags
     */
    public function createNewVersion(
        string $body,
        string $answer,
        string $name = null,
        string $description = null,
        Collection $tags = null,
    ): QuestionPrototypeVersion {
        $version = $this->questionPrototype->versions()->create([
            'name' => $name,
            'description' => $description,
            'body' => $body,
            'answer' => $answer,
        ]);

        if ($tags) {
            $version->tags()->attach($tags);
        }

        $this->questionPrototype->touch();

        $this->questionPrototype->refresh();

        return $version;
    }

    /**
     * Create a new question and attach a new version to it.
     */
    public function createNewQuestion(): void
    {
        //
    }

    /**
     * Attach a question to questionnaire at the end.
     */
    public function attachToQuestionnaire(
        QuestionPrototype $question,
        QuestionnairePrototype $questionnaire,
    ): void {
        //
    }

    public function createCommentAboutAction(
        QuestionPrototype $question,
        string $content,
    ): void {
        //
    }

    public function restoreToPreviousVersion(
        QuestionPrototype $question,
        QuestionPrototypeVersion $newVersion,
    ): void {
        //
    }

    public function markQuestionAsDisabled(
        QuestionPrototype $question,
    ): void {
        //
    }

    public function markQuestionAsEnabled(
        QuestionPrototype $question,
    ): void {
        //
    }

    /**
     * @return Collection<int, mixed>
     */
    public static function getAttachableTagsForSubject(
        Subject $subject = null,
    ): Collection {
        $tagGroups = TagGroup::default()->with('tags')->get();
        $tags = collect();
        $relatedSubjects = null;

        if ($subject) {
            $relatedSubjects = $subject->relatedSubjects()->pluck('id');
        }

        foreach ($tagGroups as $tagGroup) {
            $tags[$tagGroup->id] = $tagGroup->tags()
                ->where('active', true)
                ->where(function ($query) use ($subject, $relatedSubjects) {
                    if (!$subject) {
                        return;
                    }

                    $query->whereIn('subject_id', $relatedSubjects)
                        ->orWhere('subject_id', $subject->id)
                        ->orWhere('subject_id', null);
                })
                ->get();
        }

        return $tags;
    }
}
