<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuestionnaireController;
use App\Http\Controllers\Admin\QuestionnaireGroupController;
use App\Http\Controllers\Admin\Result\ResultController;
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

// Route::resource('periods', PeriodController::class);

// Route::resource('questionnaire-groups', QuestionnaireGroupController::class);

// Route::resource('subjects', SubjectController::class);

// Route::resource('study-plans', StudyPlanController::class);

// Route::get('divisions/upload', [DivisionController::class, 'upload'])->name('divisions.upload');
// Route::post('divisions/upload', [DivisionController::class, 'import'])->name('divisions.import');
// Route::get('divisions/upload-students', [DivisionController::class, 'uploadStudents'])->name('divisions.upload-students');
// Route::post('divisions/upload-students', [DivisionController::class, 'importStudents'])->name('divisions.import-students');
// Route::resource('divisions', DivisionController::class);

Route::get('questionnaires/{questionnaire}/upload-results', [QuestionnaireController::class, 'uploadResults'])->name('questionnaires.upload-results');
Route::post('questionnaires/{questionnaire}/upload-results', [QuestionnaireController::class, 'importResults'])->name('questionnaires.import-results');
Route::get('questionnaires/compute-stats', [QuestionnaireController::class, 'computeStatsQuestionnaires'])->name('questionnaires.compute-stats');
Route::get('questionnaires/{questionnaire}/compute-stats', [QuestionnaireController::class, 'computeStatsQuestionnaire'])->name('questionnaire.compute-stats');
Route::get('questionnaires/create-from-prototype', [QuestionnaireController::class, 'createFromPrototype'])->name('questionnaires.create-from-prototype');
Route::post('questionnaires/create-from-prototype', [QuestionnaireController::class, 'storeFromPrototype'])->name('questionnaires.store-from-prototype');
Route::resource('questionnaires', QuestionnaireController::class);

// Route::resource('questions', QuestionController::class);

Route::prefix('results')->name('results.')->group(function () {
    Route::get('{questionnaireImportAnswersResult}', [ResultController::class, 'show'])->name('show');
    Route::get('upload', [ResultController::class, 'upload'])->name('upload');
    Route::post('upload', [ResultController::class, 'import'])->name('import');
});
