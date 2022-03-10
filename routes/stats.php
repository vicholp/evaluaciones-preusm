<?php

use App\Http\Controllers\Stats\StatsController;
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

Route::get('/', [StatsController::class, 'index'])->name('index');

Route::get('/questionnaireGroup/{questionnaire_group}', [StatsController::class, 'questionnaireGroup'])->name('questionnaireGroup');
Route::get('/questionnaire/{questionnaire}', [StatsController::class, 'questionnaire'])->name('questionnaire');
Route::get('/question/{question}', [StatsController::class, 'question'])->name('question');
