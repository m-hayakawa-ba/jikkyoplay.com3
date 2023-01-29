<?php

namespace App\Http\Controllers;

use App\Services\Program\ProgramReadService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RankingController extends Controller
{
    /**
     * 定数定義
     */
    private $max_ranking_count = 20; //表示させるレビュー数

    /**
     * コンストラクタ
     */
    public function __construct(
        private ProgramReadService $programReadService,
    ){
    }

    /**
     * ランキング一覧ページ
     */
    public function index()
    {
        //ランキング一覧を取得
        $rankings = $this->programReadService->getRankings(
            $this->max_ranking_count
        );

        //viewへ遷移
        return Inertia::render('Ranking/Index', compact(
            'rankings'
        ));
    }
}
