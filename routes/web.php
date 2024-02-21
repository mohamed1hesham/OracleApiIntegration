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

Route::get('/', function () {
    return view('IntegrationPage');
});
Route::get('/request', [ApiController::class, 'Absences'])->name('request');
Route::get('/show-absences', [AjaxController::class, 'pagination'])->name('show-absences');


Route::get('b', function () {
    return view('button');
});

Route::get('/show-json', [AjaxController::class, 'showAbsences']);

Route::get('/request-workers', [ApiController::class, 'workers']);


Route::get('/pagination/pagination-data', [AjaxController::class, 'pagination']);
Route::get('/pagination/pagination-data2', [AjaxController::class, 'pagination2']);


Route::post('/ajax-datatable', [AjaxController::class, "datatable"])->name('datatable');
