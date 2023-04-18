<?php

use App\Http\Controllers\Admin\QuestionnaireController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Utils\ResultsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', IndexController::class)->name('index');

Route::get('utils/resultados', [ResultsController::class, 'index'])->name('utils.results.index');
Route::get('utils/resultados/start', [ResultsController::class, 'start'])->name('utils.results.start');
Route::post('utils/resultados/store-questionnaire', [ResultsController::class, 'storeQuestionnaire'])->name('utils.results.store-questionnaire');
Route::get('utils/resultados/{questionnaire}/upload-question', [ResultsController::class, 'uploadQuestion'])->name('utils.results.upload-question');
Route::post('utils/resultados/{questionnaire}/store-question', [ResultsController::class, 'storeQuestion'])->name('utils.results.store-question');

Route::get('hetrixtools', function () {
    return 'OK';
});

Route::post('admin/questionnaires/{questionnaire}/upload', [QuestionnaireController::class, 'importResults'])
    ->name('admin.questionnaires.import-results');

Route::post('admin/upload/users', [UploadController::class, 'users'])
    ->name('admin.upload.users');
