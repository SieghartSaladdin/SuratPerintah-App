<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuratPerintahController;
use App\Http\Controllers\FormattSpController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/test', function (Request $request) {
        return $request->user();
    });

    // Surat Perintah
    Route::get('/surat-perintah', [SuratPerintahController::class, 'index']);
    Route::post('/surat-perintah', [SuratPerintahController::class, 'store']);
    Route::post('/surat-perintah-{id}', [SuratPerintahController::class, 'update']);
    Route::delete('/surat-perintah-{id}', [SuratPerintahController::class, 'delete']);
    

    Route::get('/view-sp-{id}-{format}', [SuratPerintahController::class, 'view']);
    Route::post('/cetak-sp-{id}-{format}', [SuratPerintahController::class, 'cetak']);

    Route::get('/data-formatt-sp-1', [FormattSpController::class, 'index_sp_1']);
    Route::get('/data-formatt-sp-1-{id}', [FormattSpController::class, 'get_sp_1']);
    Route::post('/create-formatt-sp-1', [FormattSpController::class, 'store_sp_1']);
    Route::post('/update-formatt-sp-1-{id}', [FormattSpController::class, 'update_sp_1']);
    Route::delete('/delete-formatt-sp-1-{id}', [FormattSpController::class, 'delete_sp_1']);

    Route::get('/data-formatt-sp-2', [FormattSpController::class, 'index_sp_2']);
    Route::get('/data-formatt-sp-2-{id}', [FormattSpController::class, 'get_sp_2']);
    Route::post('/create-formatt-sp-2', [FormattSpController::class, 'store_sp_2']);
    Route::post('/update-formatt-sp-2-{id}', [FormattSpController::class, 'update_sp_2']);
    Route::delete('/delete-formatt-sp-2-{id}', [FormattSpController::class, 'delete_sp_2']);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});