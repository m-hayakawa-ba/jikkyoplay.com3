<?php

namespace App\Http\Controllers;

use App\Services\Creater\CreaterReadService;
use App\Services\Program\ProgramReadService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RankingController extends Controller
{
    /**
     * 定数定義
     */
    private $max_ranking_count_l = 20;      //表示させるランキング数（多い場合）
    private $max_ranking_count_s = 10;      //表示させるランキング数（少ない場合）
    private $period_ranking = '-1 week';  //表示させるランキングの集計期間

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
        //ランキング一覧を取得
        $total_rankings = $this->programReadService->getTotalRanking(
            $this->max_ranking_count_s,
            $this->period_ranking,
        );
        $creater_rankings = $this->createrReadService->getRankings(
            $this->max_ranking_count_s,
            $this->period_ranking,
        );
        $female_rankings = $this->programReadService->getFemaleRanking(
            $this->max_ranking_count_s,
            $this->period_ranking,
            'female',
        );
        $horror_rankings = $this->programReadService->getHorrorRanking(
            $this->max_ranking_count_s,
            $this->period_ranking,
            'horror',
        );
        $retro_rankings = $this->programReadService->getRetroRanking(
            $this->max_ranking_count_s,
            $this->period_ranking,
            'retro',
        );

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
