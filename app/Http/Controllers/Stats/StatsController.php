<?php

namespace App\Http\Controllers\Stats;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Period;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireGroup;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        $periods = Period::orderBy('start_date', 'DESC')->get();

        return view('stats.index', ['periods' => $periods]);
    }

    public function questionnaireGroup(QuestionnaireGroup $questionnaireGroup)
    {
        $questionnaires = $questionnaireGroup->questionnaires;

        return view('stats.questionnaireGroup', ['questionnaires' => $questionnaires]);
    }

    public function questionnaire(Questionnaire $questionnaire)
    {
        $divisions = Division::wherePeriodId($questionnaire->period->id)
            ->where(function ($query) use ($questionnaire){
                $query->whereSubjectId($questionnaire->subject->id)
                ->orWhere('subject_id', Subject::whereName('tercero')->first()->id);
            })
            ->get();

        return view('stats.questionnaire', [
            'questionnaire' => $questionnaire->load(['questions', 'questions.tags', 'questions.tags.tagGroup']),
            'divisions' => $divisions,
        ]);
    }

    public function questionnaireStudents(Questionnaire $questionnaire)
    {
        $divisions = Division::wherePeriodId($questionnaire->period->id)
            ->where(function ($query) use ($questionnaire){
                $query->whereSubjectId($questionnaire->subject->id)
                ->orWhere('subject_id', Subject::whereName('tercero')->first()->id);
            })
            ->get();

        $students = [];

        foreach($divisions as $division){
            array_push($students, ...$division->students);
        }

        return view('stats.questionnaire-students', [
            'questionnaire' => $questionnaire->load(['questions', 'questions.tags', 'questions.tags.tagGroup']),
            'students' => $students,
            'divisions' => $divisions,
        ]);
    }

    public function questionnaireStudent(Questionnaire $questionnaire, Student $student)
    {
        return view('stats.questionnaire-student', [
            'questionnaire' => $questionnaire->load(['questions', 'questions.tags', 'questions.tags.tagGroup']),
            'student' => $student,
        ]);
    }

    public function question(Question $question)
    {
        $divisions = Division::wherePeriodId($question->questionnaire->period->id)
            ->where(function ($query) use ($question){
                $query->whereSubjectId($question->questionnaire->subject->id)
                ->orWhere('subject_id', Subject::whereName('tercero')->first()->id);
            })
            ->get();

        $stats = $question->stats()->byDivision();

        return view('stats.question', [
            'question' => $question,
            'divisions' => $divisions,
            'stats' => $stats,
        ]);
    }
}
