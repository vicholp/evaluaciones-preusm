<?php

use App\Http\Controllers\Teacher\QuestionBank\QuestionBankController;
use App\Http\Controllers\Teacher\QuestionBank\QuestionPrototypeController;
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
});
