<?php

namespace App\Http\Controllers;

use App\Libs\CacheLib;
use App\Services\Creater\CreaterReadService;
use App\Services\Program\ProgramReadService;
use Inertia\Inertia;

class RankingController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct(
        private CreaterReadService $createrReadService,
        private ProgramReadService $programReadService,
    ){
    }

    /**
     * ランキング一覧ページ
     */
    public function index()
    {
        //クロージャに渡す用の変数を用意
        $that = $this;

        //ランキング一覧を取得
        $total_rankings = CacheLib::remember('ranking_total_rankings', function() use ($that) {
            return $that->programReadService->getTotalRanking(
                config('laravel.ranking_count'),
                config('laravel.ranking_period'),
            );
        });
        $creater_rankings = CacheLib::remember('ranking_creater_rankings', function() use ($that) {
            return $that->createrReadService->getRankings(
                config('laravel.ranking_count'),
                config('laravel.ranking_period'),
            );
        });
        $female_rankings = CacheLib::remember('ranking_female_rankings', function() use ($that) {
            return $that->programReadService->getFemaleRanking(
                config('laravel.ranking_count'),
                config('laravel.ranking_period'),
            );
        });
        $horror_rankings = CacheLib::remember('ranking_horror_rankings', function() use ($that) {
            return $that->programReadService->getHorrorRanking(
                config('laravel.ranking_count'),
                config('laravel.ranking_period'),
            );
        });
        $retro_rankings = CacheLib::remember('ranking_retro_rankings', function() use ($that) {
            return $that->programReadService->getRetroRanking(
                config('laravel.ranking_count'),
                config('laravel.ranking_period'),
            );
        });

        //viewへ遷移
        return Inertia::render('Ranking/Index', compact(
            'total_rankings',
            'creater_rankings',
            'female_rankings',
            'horror_rankings',
            'retro_rankings',
        ));
    }
}
