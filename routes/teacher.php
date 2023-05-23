<?php

use App\Http\Controllers\Teacher\Api\QuestionBank\QuestionnairePrototypeController as QuestionBankQuestionnairePrototypeController;
use App\Http\Controllers\Teacher\Api\QuestionBank\QuestionPrototypeController as QuestionBankQuestionPrototypeController;
use App\Http\Controllers\Teacher\Api\QuestionBank\QuestionPrototypeVersionController;
use App\Http\Controllers\Teacher\Api\QuestionBank\StatementPrototypeController as QuestionBankStatementPrototypeController;
use App\Http\Controllers\Teacher\Api\QuestionBank\SubjectController;
use App\Http\Controllers\Teacher\Api\QuestionBank\TagController;
use App\Http\Controllers\Teacher\QuestionBank\ManualUploadController;
use App\Http\Controllers\Teacher\QuestionBank\QuestionBankController;
use App\Http\Controllers\Teacher\QuestionBank\QuestionnairePrototypeController;
use App\Http\Controllers\Teacher\QuestionBank\QuestionPrototypeController;
use App\Http\Controllers\Teacher\QuestionBank\RevisionController;
use App\Http\Controllers\Teacher\QuestionBank\StatementPrototypeController;
use App\Http\Controllers\Teacher\Results\QuestionController;
use App\Http\Controllers\Teacher\Results\QuestionnaireController;
use App\Http\Controllers\Teacher\Results\QuestionnaireGroupController;
use App\Http\Controllers\Teacher\Results\QuestionnaireStudentController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TeacherController::class, 'index'])->name('index');

Route::prefix('results')->name('results.')->group(function () {
    Route::resource('questionnaire-groups', QuestionnaireGroupController::class)->only(['index', 'show']);
    Route::resource('questionnaires', QuestionnaireController::class)->only(['index', 'show']);
    Route::resource('questions', QuestionController::class)->only(['show']);
    Route::resource('students', StudentController::class)->only(['index', 'show']);
    Route::resource('questionnaires.students', QuestionnaireStudentController::class)->only(['index', 'show']);
});

Route::prefix('bank')->name('question-bank.')->group(function () {
    Route::get('/', [QuestionBankController::class, 'index'])->name('index');

    Route::post('question-prototypes/{questionPrototype}/review', [QuestionPrototypeController::class, 'review'])->name('question-prototypes.review');
    Route::resource('question-prototypes', QuestionPrototypeController::class);

    Route::get('questionnaire-prototypes/compilation', [QuestionnairePrototypeController::class, 'createCompilation'])->name('questionnaire-prototypes.compilation.create');
    Route::post('questionnaire-prototypes/compilation', [QuestionnairePrototypeController::class, 'storeCompilation'])->name('questionnaire-prototypes.compilation.store');
    Route::get('questionnaire-prototypes/{questionnairePrototype}/moodle-export', [QuestionnairePrototypeController::class, 'moodleExport'])->name('questionnaire-prototypes.moodle-export');
    Route::get('questionnaire-prototypes/{questionnairePrototype}/full', [QuestionnairePrototypeController::class, 'full'])->name('questionnaire-prototypes.full');
    Route::get('questionnaire-prototypes/{questionnairePrototype}/edit-questions', [QuestionnairePrototypeController::class, 'editQuestions'])->name('questionnaire-prototypes.edit-questions');
    Route::put('questionnaire-prototypes/{questionnairePrototype}/questions', [QuestionnairePrototypeController::class, 'updateQuestions'])->name('questionnaire-prototypes.update-questions');
    Route::resource('questionnaire-prototypes', QuestionnairePrototypeController::class);

    Route::resource('statement-prototypes', StatementPrototypeController::class);

    Route::prefix('manual-upload')->name('manual-upload.')->group(function () {
        Route::get('start', [ManualUploadController::class, 'start'])->name('start');
        Route::post('store-questionnaire', [ManualUploadController::class, 'storeQuestionnaire'])->name('store-questionnaire');
        Route::get('{questionnairePrototype}/create-question', [ManualUploadController::class, 'createQuestion'])->name('create-question');
        Route::post('{questionnairePrototype}/store-question', [ManualUploadController::class, 'storeQuestion'])->name('store-question');
        Route::get('{questionnairePrototype}/review', [ManualUploadController::class, 'review'])->name('review');
    });

    Route::prefix('revision')->name('revision.')->group(function () {
        Route::get('questionnaire/{questionnairePrototypeVersion}', [RevisionController::class, 'questionnaire'])->name('questionnaire');
        Route::get('questionnaire/{questionnairePrototypeVersion}/question/{questionPrototypeVersion}', [RevisionController::class, 'question'])->name('question');
        Route::post('questionnaire/{questionnairePrototypeVersion}/question/{questionPrototypeVersion}/remove', [RevisionController::class, 'removeQuestion'])->name('remove-question');
        Route::put('questionnaire/{questionnairePrototypeVersion}/question/{questionPrototypeVersion}/update', [RevisionController::class, 'updateQuestion'])->name('update-question');
        Route::post('questionnaire/{questionnairePrototypeVersion}/question/{questionPrototypeVersion}/review', [RevisionController::class, 'review'])->name('review');
    });
});

Route::prefix('api')->name('api.')->group(function () {
    Route::prefix('question-bank')->name('question-bank.')->group(function () {
        Route::apiResource('question-prototype-versions', QuestionPrototypeVersionController::class);
        Route::apiResource('statement-prototypes', QuestionBankStatementPrototypeController::class);
        Route::apiResource('question-prototypes', QuestionBankQuestionPrototypeController::class);
        Route::apiResource('questionnaire-prototypes', QuestionBankQuestionnairePrototypeController::class);
        Route::apiResource('tags', TagController::class);
        Route::apiResource('subjects', SubjectController::class);
    });
});
