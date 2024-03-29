<?php

namespace App\Models;

use App\Services\Stats\StudentStatsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * App\Models\Student.
 *
 * @property int                                                                      $id
 * @property \Illuminate\Support\Carbon|null                                          $created_at
 * @property \Illuminate\Support\Carbon|null                                          $updated_at
 * @property int                                                                      $user_id
 * @property string                                                                   $uuid
 * @property string|null                                                              $gender
 * @property int|null                                                                 $year_born
 * @property string|null                                                              $city
 * @property string|null                                                              $stats
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Division>      $divisions
 * @property int|null                                                                 $divisions_count
 * @property string                                                                   $name
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Questionnaire> $questionnaires
 * @property int|null                                                                 $questionnaires_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question>      $questions
 * @property int|null                                                                 $questions_count
 * @property \App\Models\User                                                         $user
 *
 * @method static \Database\Factories\StudentFactory            factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereStats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereYearBorn($value)
 *
 * @mixin \Eloquent
 */
class Student extends Model
{
    use HasFactory;

    private StudentStatsService $statsService;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'uuid',
    ];

    public static function getUniqueUuid(): string
    {
        $uuid = (string) Str::uuid();

        while (Student::whereUuid($uuid)->exists()) {
            $uuid = (string) Str::uuid();
        }

        return $uuid;
    }

    /**
     * @return BelongsTo<User, Student>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany<Division>
     */
    public function divisions()
    {
        return $this->belongsToMany(Division::class);
    }

    public function attachAlternative(Alternative $alternative): void
    {
        $this->belongsToMany(Alternative::class)->attach($alternative);

        try {
            $this->questionnaires()->attach($alternative->question->questionnaire);
        } catch (\Exception $e) {
            if ($e->getCode() != 23000) {
                throw $e;
            }
        }

        try {
            $this->questions()->attach($alternative->question, ['alternative_id' => $alternative->id]);
        } catch (\Exception $e) {
            if ($e->getCode() != 23000) {
                throw $e;
            }
        }
    }

    /**
     * Note: this method does not detach the question nor the questionnaire from the student.
     */
    public function detachAlternative(Alternative $alternative): void
    {
        $this->belongsToMany(Alternative::class)->detach($alternative);
    }

    /**
     * Note: this method does not detach the questionnaire from the student.
     */
    public function detachAlternativesFromQuestion(Question $question): void
    {
        $this->belongsToMany(Alternative::class)->detach($question->alternatives);

        $this->questions()->detach($question);
    }

    /**
     * @return BelongsToMany<Questionnaire>
     */
    public function questionnaires()
    {
        // this relation has a 'score' column in the pivot table, but it should not be
        // used because it will be null before calculating the score. Instead, use
        // the $this->stats()->getScoreInQuestionnaire() method.

        return $this->belongsToMany(Questionnaire::class)->using(QuestionnaireStudent::class)->withPivot(['stats', 'score']);
    }

    /**
     * @return BelongsToMany<Question>
     */
    public function questions()
    {
        // this relations has 'score' column, but it should not be
        // used because they will be null before calculating the score. Instead, use
        // the $this->stats()->getScoreInQuestion() method.

        return $this->belongsToMany(Question::class)->using(QuestionStudent::class)->withPivot(['alternative_id', 'stats', 'score']);
    }

    public function stats(): StudentStatsService
    {
        if (!isset($this->statsService)) {
            $this->statsService = new StudentStatsService($this);
        }

        return $this->statsService;
    }

    public function getStatsAttribute(): ?string
    {
        return $this->stats ?? null;
    }

    public function getNameAttribute(): string
    {
        return $this->user->name;
    }
}
