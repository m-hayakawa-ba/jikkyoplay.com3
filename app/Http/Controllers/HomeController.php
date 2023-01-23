<?php

namespace App\Http\Controllers;

use App\Services\News\NewsReadService;
use App\Services\Program\ProgramReadService;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * 定数定義
     */
    private $max_news_count = 4;    //表示させる最新ニュース
    private $max_ranking_count = 4; //表示させるランキング

    /**
     * コンストラクタ
     */
    public function __construct(
        private NewsReadService $newsReadService,
        private ProgramReadService $programReadService,
    ){
    }

    /**
     * トップページを表示
     */
    public function index()
    {
        //最新ニュースを取得
        $newses = $this->newsReadService->getNewsAtHome($this->max_news_count);

        //今週のランキングを取得
        $programs = $this->programReadService->getRanking($this->max_ranking_count);

        //viewへ遷移
        return Inertia::render('Home/Index', compact(
            'newses',
            'programs',
        ));
    }
}
