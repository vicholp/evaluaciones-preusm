<?php

use App\Http\Controllers\StudentController;
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

Route::get('/', [StudentController::class, 'index']);
Route::get('estudiante/get', [StudentController::class, 'get'])->name('students.get');
Route::get('estudiante/{user:rut}', [StudentController::class, 'show'])->name('students.index');
Route::get('estudiante/{user:rut}/ensayo/{questionnaire}', [StudentController::class, 'questionnaire'])->name('students.questionnaire');

Route::get('hetrixtools', function () { return 'OK'; });
