<?php

namespace App\Services\QuestionBank;

use App\Models\QuestionPrototype;
use App\Models\QuestionPrototypeVersion;
use App\Models\User;

/**
 * This class is responsible for managing the reviews of a question prototype version.
 *
 * A review of an old version can not be removed, only the reviews of the last version can.
 */
class ReviewService
{
    private QuestionPrototype $questionPrototype;

    public function __construct(
        private QuestionPrototypeVersion $questionPrototypeVersion,
        ?QuestionPrototype $questionPrototype = null,
    ) {
        if ($questionPrototype === null) {
            $this->questionPrototype = $this->questionPrototypeVersion->parent;
        }
    }

    /**
     * If the user has already reviewed the question prototype version, the review is removed.
     *
     * If the user can review the question prototype version, a new review is created.
     */
    public function reviewAction(User $user): void
    {
        if ($this->versionIsReviewedBy($user)) {
            $this->unmarkAsReviewedBy($user);

            return;
        }

        if ($this->canBeReviewedBy($user)) {
            $this->markAsReviewedBy($user);

            return;
        }
    }

    public function getReviewButtonName(User $user): string
    {
        if ($this->versionIsReviewedBy($user)) {
            return 'unreview';
        }

        if ($this->olderVersionIsReviewedBy($user)) {
            return 'update review';
        }

        if (!$this->questionIsReviewedBy($user)) {
            return 'review';
        }

        return 'nothing';
    }

    public function getReviewsOfVersion(): mixed
    {
        return $this->questionPrototypeVersion->reviews;
    }

    public function getReviewsOfQuestion(): mixed
    {
        return $this->questionPrototype->reviews;
    }

    public function getLastReviewer(): ?User
    {
        return $this->questionPrototype->reviews()->latest()->first()?->user;
    }

    /**
     * A question prototype version can be reviewed if:
     * - the user has not reviewed the question prototype version yet
     * - the user has not reviewed the question prototype yet.
     */
    public function canBeReviewedBy(User $user): bool
    {
        return !$this->questionIsReviewedBy($user) || $this->olderVersionIsReviewedBy($user);
    }

    public function versionIsReviewedBy(User $user): bool
    {
        return $this->questionPrototypeVersion->reviews()->whereUserId($user->id)->exists();
    }

    public function questionIsReviewedBy(User $user): bool
    {
        return $this->questionPrototype->reviews()->whereUserId($user->id)->exists();
    }

    public function versionIsReviewed(): bool
    {
        return $this->questionPrototypeVersion->reviews()->exists();
    }

    public function questionIsReviewed(): bool
    {
        return $this->questionPrototype->reviews()->exists();
    }

    public function olderVersionIsReviewedBy(User $user): bool
    {
        return $this->questionIsReviewedBy($user) && !$this->versionIsReviewedBy($user);
    }

    public function markAsReviewedBy(User $user): void
    {
        $this->questionPrototypeVersion->reviews()->create([
            'user_id' => $user->id,
            'question_prototype_id' => $this->questionPrototype->id,
        ]);
    }

    /**
     * This method remove the last review of the user for the question prototype.
     */
    public function unmarkAsReviewedBy(User $user): void
    {
        $this->questionPrototypeVersion->reviews()->whereUserId($user->id)->delete();
    }
}
