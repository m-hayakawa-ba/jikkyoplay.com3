<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;

//トップページ
Route::get('/', [HomeController::class, 'index']);

//ニュース一覧
Route::get('/news', [NewsController::class, 'index']);
