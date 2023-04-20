<?php

namespace App\Services\Stats;

use App\Models\QuestionStudent;
use App\Services\Stats\Compute\ComputeQuestionStudentStatsService;

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
