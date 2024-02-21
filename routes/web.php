<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ApiController::class, 'index']);
Route::get('/request', [ApiController::class, 'Absences'])->name('request');
Route::get('/requestEmps', [ApiController::class, 'EmployeesIntegration'])->name('requestEmps');
Route::get('/show-absences', [AjaxController::class, 'show_absence'])->name('show-absences');
Route::post('/Absencedatatable', [AjaxController::class, "Absencedatatable"])->name('Absencedatatable');








Route::get('/show-json', [AjaxController::class, 'showAbsences']);
Route::get('/request-workers', [ApiController::class, 'workers']);
Route::get('/pagination/pagination-data', [AjaxController::class, 'pagination']);
Route::get('/pagination/pagination-data2', [AjaxController::class, 'pagination2']);
