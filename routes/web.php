<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\ProgramController;

//トップページ
Route::get('/', [HomeController::class, 'index']);

//ニュース一覧
Route::get('/news', [NewsController::class, 'index']);

//ランキング
Route::get('/ranking', [RankingController::class, 'index']);

//動画ページ
Route::get('/program', [ProgramController::class, 'index']);
Route::get('/program/{program_id}', [ProgramController::class, 'show']);
