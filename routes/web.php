<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LotteryController;

Route::get('/', [LotteryController::class, 'index']);
Route::get('/soi-cau', [LotteryController::class, 'prediction']);
Route::get('/thong-ke', [LotteryController::class, 'statistics']);
Route::get('/lich-su/{region?}', [LotteryController::class, 'history']);
Route::get('/bridge', [LotteryController::class, 'bridge']);
Route::get('/backend/bridge', [LotteryController::class, 'bridge']);
