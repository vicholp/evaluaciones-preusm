<?php

namespace App\Services\Stats;

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireStudent;
use App\Models\QuestionStudent;
use App\Models\Student;
use App\Models\Tag;
use App\Models\TagGroup;
use App\Services\Stats\Compute\ComputeQuestionStudentStatsService;
use App\Services\Stats\Compute\ComputeStudentStatsService;

/**
 * Class StudentStatsService.
 */
class QuestionStudentStatsService extends StatsService
{
    private ComputeQuestionStudentStatsService $computeClass;

    public function __construct(
        private QuestionStudent $questionStudent
    ) {
        $stats = [];

        $this->computeClass = new ComputeQuestionStudentStatsService($questionStudent);

        parent::__construct($stats, $questionStudent);
    }
}
