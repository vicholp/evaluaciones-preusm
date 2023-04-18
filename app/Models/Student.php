<?php

namespace App\Models;

use App\Services\Stats\StudentStatsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * App\Models\Student
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property string $uuid
 * @property string|null $gender
 * @property int|null $year_born
 * @property string|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Division[] $divisions
 * @property-read int|null $divisions_count
 * @property-read string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Questionnaire[] $questionnaires
 * @property-read int|null $questionnaires_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @property-read int|null $questions_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\StudentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereYearBorn($value)
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

    public function detachAlternative(Alternative $alternative): void
    {
        $this->belongsToMany(Alternative::class)->detach($alternative);

        // $this->questionnaires()->detach($alternative->question->questionnaire);
        // $this->questions()->detach($alternative->question);
    }

    public function detachAlternativesFromQuestion(Question $question): void
    {
        $this->belongsToMany(Alternative::class)->detach($question->alternatives);

        $this->questions()->detach($question);
        // $this->questionnaires()->detach($question->questionnaire);
    }

    /**
     * @return BelongsToMany<Questionnaire>
     */
    public function questionnaires()
    {
        // this relation has a 'score' column in the pivot table, but it should not be
        // used because it will be null before calculating the score. Instead, use
        // the $this->stats()->getScoreInQuestionnaire() method.

        return $this->belongsToMany(Questionnaire::class)->using(QuestionnaireStudent::class);;
    }

    /**
     * @return BelongsToMany<Question>
     */
    public function questions()
    {
        // this relations has 'score' column, but it should not be
        // used because they will be null before calculating the score. Instead, use
        // the $this->stats()->getScoreInQuestion() method.

        return $this->belongsToMany(Question::class)->using(QuestionStudent::class)->withPivot('alternative_id');
    }

    public function stats(): StudentStatsService
    {
        if (!isset($this->statsService)) {
            $this->statsService = new StudentStatsService($this);
        }

        return $this->statsService;
    }

    public function getNameAttribute(): string
    {
        return $this->user->name;
    }
}
