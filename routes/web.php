<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\ReviewController;

//トップページ
Route::get('/', [HomeController::class, 'index']);

//ニュース一覧
Route::get('/news/{month?}', [NewsController::class, 'index']);

//ランキング
Route::get('/ranking', [RankingController::class, 'index']);

//動画ページ
Route::get('/program', [ProgramController::class, 'index']);
Route::get('/program/{program_id}', [ProgramController::class, 'show']);
Route::post('/program/voice/{program_id}', [ProgramController::class, 'updateVoice']);
Route::post('/program/game/{program_id}', [ProgramController::class, 'updateGame']);


Route::post('/game/search', [GameController::class, 'search']);
Route::post('/review', [ReviewController::class, 'store']);
