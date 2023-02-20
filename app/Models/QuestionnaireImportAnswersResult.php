<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\QuestionnaireImportAnswersResult.
 *
 * @property int                                                                         $id
 * @property int|null                                                                    $root_questionnaire_import_answers_result_id
 * @property int|null                                                                    $parent_questionnaire_import_answers_result_id
 * @property int                                                                         $questionnaire_id
 * @property int|null                                                                    $student_id
 * @property int|null                                                                    $alternative_id
 * @property int|null                                                                    $question_id
 * @property int|null                                                                    $admin_id
 * @property mixed|null                                                                  $data
 * @property mixed|null                                                                  $log
 * @property string|null                                                                 $result
 * @property \Illuminate\Support\Carbon|null                                             $created_at
 * @property \Illuminate\Support\Carbon|null                                             $updated_at
 * @property \App\Models\Admin|null                                                      $admin
 * @property \App\Models\Alternative|null                                                $alternative
 * @property \Illuminate\Database\Eloquent\Collection|QuestionnaireImportAnswersResult[] $childs
 * @property int|null                                                                    $childs_count
 * @property \App\Models\Question|null                                                   $question
 * @property \App\Models\Questionnaire                                                   $questionnaire
 * @property \App\Models\Student|null                                                    $student
 *
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult whereAlternativeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult whereLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult whereParentQuestionnaireImportAnswersResultId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult whereRootQuestionnaireImportAnswersResultId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionnaireImportAnswersResult whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class QuestionnaireImportAnswersResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'root_questionnaire_import_answers_result_id',
        'parent_questionnaire_import_answers_result_id',
        'questionnaire_id',
        'student_id',
        'alternative_id',
        'question_id',
        'admin_id',
        'data',
        'log',
        'result',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'data' => AsCollection::class,
        'log' => AsCollection::class,
    ];

    public function insertIntoData(array $data): void
    {
        $this->data->push($data);

        $this->save();
    }

    public function setResult(string $result): void
    {
        $this->result = $result;

        $this->save();
    }

    public function insertIntoLog(string $result, Student $student = null, Question $question = null): void
    {
        $this->log->push($result);

        if ($this->student == null) {
            $this->student()->associate($student);
        }

        if ($this->question == null) {
            $this->question()->associate($question);
        }

        $this->save();
    }

    public function createChild(string $result, array $data = [], Student $student = null, Question $question = null): self
    {
        $record = self::create([
            'root_questionnaire_import_answers_result_id' => $this->root_questionnaire_import_answers_result_id ?? $this->id,
            'parent_questionnaire_import_answers_result_id' => $this->id,
            'questionnaire_id' => $this->questionnaire_id,
            'student_id' => $student->id ?? null,
            'question_id' => $question->id ?? null,
            'admin_id' => $this->admin_id,
            'data' => $data,
            'log' => [$result],
            'result' => 'processing',
        ]);

        return $record;
    }

    /**
     * @return HasMany<QuestionnaireImportAnswersResult>
     */
    public function childs()
    {
        return $this->hasMany(self::class, 'parent_questionnaire_import_answers_result_id');
    }

    /**
     * @return BelongsTo<Questionnaire, QuestionnaireImportAnswersResult>
     */
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    /**
     * @return BelongsTo<Student, QuestionnaireImportAnswersResult>
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * @return BelongsTo<Alternative, QuestionnaireImportAnswersResult>
     */
    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }

    /**
     * @return BelongsTo<Question, QuestionnaireImportAnswersResult>
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return BelongsTo<Admin, QuestionnaireImportAnswersResult>
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
