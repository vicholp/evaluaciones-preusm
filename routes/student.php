<?php

use App\Http\Controllers\Student\ResultsController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StudentController::class, 'index'])->name('index');
Route::post('login', [StudentController::class, 'login'])->name('login');

Route::prefix('results')->name('results.')->group(function () {
    Route::get('questionnaireGroup/{questionnaireGroup}', [ResultsController::class, 'questionnaireGroup'])->name('questionnaire-group');
    Route::get('questionnaire/{questionnaire}', [ResultsController::class, 'questionnaire'])->name('questionnaire');
});
