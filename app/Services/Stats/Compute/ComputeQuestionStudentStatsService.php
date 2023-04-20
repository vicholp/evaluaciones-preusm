<?php

namespace App\Services\Stats\Compute;

use App\Models\QuestionStudent;

/**
 * Class StudentStatsService.
 */
class ComputeQuestionStudentStatsService
{
    public function __construct(
        private QuestionStudent $questionStudent,
    ) {
        //
    }
}
