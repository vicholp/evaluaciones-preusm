<?php

namespace App\Services\Stats\Compute;

use App\Models\Alternative;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireStudent;
use App\Models\QuestionStudent;
use App\Models\Student;
use App\Models\Tag;
use App\Models\TagGroup;

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
