<?php

namespace App\Services\Stats;

use App\Models\QuestionnaireGroup;
use App\Services\Stats\Compute\ComputeQuestionnaireGroupStatsService;

/**
 * Class QuestionnaireGroupStatsService
 * @package App\Services
 */
class QuestionnaireGroupStatsService extends StatsService
{
    private ComputeQuestionnaireGroupStatsService $computeClass;

    public function __construct(
        private QuestionnaireGroup $questionnaireGroup,
    ) {
        $stats = [
            'sentCount' => null,
            'studentsSentCount' => null,
            'tagsOnQuestions' => null,
        ];

        $this->computeClass = new ComputeQuestionnaireGroupStatsService($this->questionnaireGroup);

        parent::__construct("questionnaire-group.{$this->questionnaireGroup->id}", $stats);
    }

    public function getSentCount(): int
    {
        if (!$this->stats['sentCount']) {
            $this->setStats('sentCount', $this->computeClass->sentCount());
        }

        return $this->stats['sentCount'];
    }

    public function getStudentsSentCount(): int
    {
        if (!$this->stats['studentsSentCount']) {
            $this->setStats('studentsSentCount', $this->computeClass->studentsSentCount());
        }

        return $this->stats['studentsSentCount'];
    }
}
