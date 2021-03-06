<?php

namespace App\Models;

use App\Services\Stats\StudentStatsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Alternative[] $alternatives
 * @property-read int|null $alternatives_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Division[] $divisions
 * @property-read int|null $divisions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @property-read int|null $questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subject[] $subjects
 * @property-read int|null $subjects_count
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

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'uuid',
    ];


    public static function getUniqueUuid()
    {
        $uuid = (string) Str::uuid();
        while(Student::whereUuid($uuid)->exists())
        $uuid = (string) Str::uuid();

        return $uuid;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function divisions()
    {
        return $this->belongsToMany(Division::class);
    }

    public function alternatives()
    {
        return $this->belongsToMany(Alternative::class);
    }

    public function subjects()
    {
        return $this->hasManyThrough(Subject::class, Division::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withPivot('correct');
    }

    public function sentQuestionnaire(Questionnaire $questionnaire)
    {
        if ($this->alternatives()->whereQuestionId($questionnaire->questions[0]->id)->first() !== null) return true;

        return false;
    }

    public function stats()
    {
        return new StudentStatsService($this);
    }

    public function correctAnswer(Question $question) : bool
    {
        $alternatives = $question->alternatives;

        foreach($alternatives as $alternative) {
            $result = $alternative->students->find($this->id);
            if($result !== null) return $alternative->correct;
        }

        return false;
    }

    public function score(Questionnaire $questionnaire) : int
    {
        $result = [];
        $grade = 0;

        foreach ($this->alternatives as $alternative) {
            if ($alternative->question->questionnaire->id == $questionnaire->id){
                array_push($result, $alternative);
            }
        }

        if(count($result) == 0){
            return -1;
        }

        foreach($result as $question){
            if ($question->correct) $grade+=1;
        }

        return $grade;
    }
}
