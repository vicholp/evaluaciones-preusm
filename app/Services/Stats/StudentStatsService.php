<?php

namespace App\Services\Stats;

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireStudent;
use App\Models\QuestionStudent;
use App\Models\Student;
use App\Services\Stats\Compute\ComputeStudentStatsService;
use Illuminate\Support\Facades\Cache;

/**
 * Class StudentStatsService
 * @package App\Services
 */
class StudentStatsService extends StatsService
{
    private ComputeStudentStatsService $computeClass;

    public function __construct(
        private Student $student
    ) {
        $this->computeClass = new ComputeStudentStatsService($student);
        // $this->getStats();
    }

    // private array $stats = [
    //     //
    // ];

    // private function getStats(): void
    // {
    //     $fromCache = Cache::store('database')->get("stats.student.{$this->student->id}", false);

    //     if ($fromCache) {
    //         $this->stats = json_decode($fromCache, true);
    //     }
    // }

    // private function setStats(string $key, string|bool|int|float|array|null $value): void
    // {
    //     $this->stats[$key] = $value;

    //     Cache::store('database')->put("stats.student.{$this->student->id}", json_encode($this->stats), self::cache_time);
    // }

    public function getScoreInQuestionnaire(Questionnaire $questionnaire): int
    {
        $questionnaireStudent = QuestionnaireStudent::whereStudentId($this->student->id)->whereQuestionnaireId($questionnaire->id)->first();

        if (!$questionnaireStudent) {
            return 0;
        }

        if ($questionnaireStudent->score == null) {
            $questionnaireStudent->score = $this->computeClass->scoreInQuestionnaire($questionnaireStudent);
            $questionnaireStudent->save();
        }

        return $questionnaireStudent->score;
    }

    public function getScoreInQuestion(Question $question): int
    {
        $questionStudent = QuestionStudent::whereStudentId($this->student->id)->whereQuestionId($question->id)->first();

        if (!$questionStudent) {
            return 0;
        }

        if ($questionStudent->score == null) {
            $questionStudent->score = $this->computeClass->scoreInQuestion($questionStudent);
            $questionStudent->save();
        }

        return $questionStudent->score;
    }
}
