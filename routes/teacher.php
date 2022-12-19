<?php

use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\QuestionController;
use App\Http\Controllers\Teacher\QuestionnaireController;
use App\Http\Controllers\Teacher\QuestionnaireGroupController;
use App\Http\Controllers\Teacher\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TeacherController::class, 'index'])->name('index');

Route::resource('questionnaire-groups', QuestionnaireGroupController::class);
Route::resource('questionnaires', QuestionnaireController::class);
Route::resource('questions', QuestionController::class);
Route::resource('students', StudentController::class);
