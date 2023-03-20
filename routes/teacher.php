<?php

use App\Http\Controllers\Teacher\Api\QuestionBank\QuestionnairePrototypeController as QuestionBankQuestionnairePrototypeController;
use App\Http\Controllers\Teacher\Api\QuestionBank\QuestionPrototypeController as QuestionBankQuestionPrototypeController;
use App\Http\Controllers\Teacher\Api\QuestionBank\QuestionPrototypeVersionController;
use App\Http\Controllers\Teacher\Api\QuestionBank\StatementPrototypeController as QuestionBankStatementPrototypeController;
use App\Http\Controllers\Teacher\Api\QuestionBank\SubjectController;
use App\Http\Controllers\Teacher\Api\QuestionBank\TagController;
use App\Http\Controllers\Teacher\QuestionBank\QuestionBankController;
use App\Http\Controllers\Teacher\QuestionBank\QuestionnairePrototypeController;
use App\Http\Controllers\Teacher\QuestionBank\QuestionPrototypeController;
use App\Http\Controllers\Teacher\QuestionBank\RevisionController;
use App\Http\Controllers\Teacher\QuestionBank\StatementPrototypeController;
use App\Http\Controllers\Teacher\QuestionController;
use App\Http\Controllers\Teacher\QuestionnaireController;
use App\Http\Controllers\Teacher\QuestionnaireGroupController;
use App\Http\Controllers\Teacher\QuestionnaireStudentController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TeacherController::class, 'index'])->name('index');

Route::resource('questionnaire-groups', QuestionnaireGroupController::class)->only(['index', 'show']);
Route::resource('questionnaires', QuestionnaireController::class)->only(['index', 'show']);
Route::resource('questions', QuestionController::class)->only(['show']);
Route::resource('students', StudentController::class)->only(['index', 'show']);
Route::resource('questionnaires.students', QuestionnaireStudentController::class)->only(['index', 'show']);

Route::prefix('bank')->name('question-bank.')->group(function () {
    Route::get('/', [QuestionBankController::class, 'index'])->name('index');
    Route::resource('question-prototypes', QuestionPrototypeController::class);

    Route::get('questionnaire-prototypes/{questionnairePrototype}/edit-questions', [QuestionnairePrototypeController::class, 'editQuestions'])->name('questionnaire-prototypes.edit-questions');
    Route::put('questionnaire-prototypes/{questionnairePrototype}/questions', [QuestionnairePrototypeController::class, 'updateQuestions'])->name('questionnaire-prototypes.update-questions');
    Route::resource('questionnaire-prototypes', QuestionnairePrototypeController::class);
    Route::resource('statement-prototypes', StatementPrototypeController::class);

    Route::prefix('revision')->name('revision.')->group(function () {
        Route::get('questionnaire/{questionnairePrototypeVersion}', [RevisionController::class, 'questionnaire'])->name('questionnaire');
        Route::get('questionnaire/{questionnairePrototypeVersion}/question/{questionPrototypeVersion}', [RevisionController::class, 'question'])->name('question');
        Route::post('questionnaire/{questionnairePrototypeVersion}/question/{questionPrototypeVersion}/remove', [RevisionController::class, 'removeQuestion'])->name('remove-question');
        Route::put('questionnaire/{questionnairePrototypeVersion}/question/{questionPrototypeVersion}/update', [RevisionController::class, 'updateQuestion'])->name('update-question');
    });
});

Route::prefix('api')->name('api.')->group(function () {
    Route::prefix('question-bank')->name('question-bank.')->group(function () {
        Route::apiResource('question-protoype-versions', QuestionPrototypeVersionController::class);
        Route::apiResource('statement-prototypes', QuestionBankStatementPrototypeController::class);
        Route::apiResource('question-prototypes', QuestionBankQuestionPrototypeController::class);
        Route::apiResource('questionnaire-prototypes', QuestionBankQuestionnairePrototypeController::class);
        Route::apiResource('tags', TagController::class);
        Route::apiResource('subjects', SubjectController::class);
    });
});
