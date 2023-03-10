<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Services\Creater\CreaterReadService;
use App\Services\Program\ProgramReadService;
use Inertia\Inertia;

class RankingController extends Controller
{
    /**
     * 定数定義
     */
    private $max_ranking_count_l = 20;   //表示させるランキング数（多い場合）
    private $max_ranking_count_s = 10;   //表示させるランキング数（少ない場合）
    private $period_ranking = '-1 week'; //表示させるランキングの集計期間

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
        $total_rankings = Cache::remember('ranking_total_rankings', 60*60, function() use ($that) {
            return $that->programReadService->getTotalRanking(
                $that->max_ranking_count_s,
                $that->period_ranking,
            );
        });
        $creater_rankings = Cache::remember('ranking_creater_rankings', 60*60, function() use ($that) {
            return $that->createrReadService->getRankings(
                $that->max_ranking_count_s,
                $that->period_ranking,
            );
        });
        $female_rankings = Cache::remember('ranking_female_rankings', 60*60, function() use ($that) {
            return $that->programReadService->getFemaleRanking(
                $that->max_ranking_count_s,
                $that->period_ranking,
                'female',
            );
        });
        $horror_rankings = Cache::remember('ranking_horror_rankings', 60*60, function() use ($that) {
            return $that->programReadService->getHorrorRanking(
                $that->max_ranking_count_s,
                $that->period_ranking,
                'horror',
            );
        });
        $retro_rankings = Cache::remember('ranking_retro_rankings', 60*60, function() use ($that) {
            return $that->programReadService->getRetroRanking(
                $that->max_ranking_count_s,
                $that->period_ranking,
                'retro',
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
