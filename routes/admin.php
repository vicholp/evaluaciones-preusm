<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\QuestionnaireController;
use App\Http\Controllers\Admin\QuestionnaireGroupController;
use App\Http\Controllers\Admin\StudyPlanController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AdminController::class, 'index'])->name('index');

Route::get('users/upload', [UserController::class, 'upload'])->name('users.upload');
Route::post('users/upload', [UserController::class, 'import'])->name('users.import');
Route::resource('users', UserController::class);

Route::resource('periods', PeriodController::class);

Route::resource('questionnaire-groups', QuestionnaireGroupController::class);

Route::resource('subjects', SubjectController::class);

Route::resource('study-plans', StudyPlanController::class);

Route::resource('divisions', DivisionController::class);

Route::resource('questionnaires', QuestionnaireController::class);

Route::get('logs', [LogViewerController::class, 'index'])->name('logs');
