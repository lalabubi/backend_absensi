<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::get('kehadiran', [GuruController::class, 'getKehadiran']);
    Route::post('presensi', [PresensiController::class, 'presensi']);
    Route::get('presensi/telat', [PresensiController::class, 'getTelat']);
    Route::get('presensi/hadir', [PresensiController::class, 'getHadir']);
    Route::get('presensi/minggu', [PresensiController::class, 'getPresensiWeekly']);
    Route::get('presensi/bulan', [PresensiController::class, 'getPresensiMonthly']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
});
