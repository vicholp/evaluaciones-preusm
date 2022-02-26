<?php

namespace App\Models;

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
 * @property-read \App\Models\User $user
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
        return $this->divisions;
        return $this->hasManyThrough(Subject::class, Division::class);
    }

    public function grade(Questionnaire $questionnaire)
    {
        $result = [];
        $grade = 0;
        foreach ($this->alternatives as $alternative) {
            if ($alternative->question->questionnaire->id == $questionnaire->id){
                array_push($result, $alternative);
            }
        }
        foreach($result as $question){
            if ($question->correct) $grade+=1;
        }
        return $grade;
    }
}
