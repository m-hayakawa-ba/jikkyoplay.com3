<?php

namespace App\Http\Controllers;

use App\Services\News\NewsReadService;
use App\Services\Program\ProgramReadService;
use App\Services\Review\ReviewReadService;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * 定数定義
     */
    private $max_news_count = 4;    //表示させる最新ニュース
    private $max_ranking_count = 4; //表示させるランキング
    private $max_program_count = 2; //サイトごとの表示させる新着動画
    private $max_review_count = 2;  //表示させるレビュー数

    /**
     * コンストラクタ
     */
    public function __construct(
        private NewsReadService $newsReadService,
        private ProgramReadService $programReadService,
        private ReviewReadService $reviewReadService,
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
        $rankings = $this->programReadService->getRankings($this->max_ranking_count);

        //新着動画を取得
        $youtube_programs = $this->programReadService->getLatestProgramsEverySite(
            $this->max_program_count,
            config('const.site.youtube'),
        );
        $nicovideo_programs = $this->programReadService->getLatestProgramsEverySite(
            $this->max_program_count,
            config('const.site.nicovideo'),
        );

        //おすすめレビューを取得
        $reviews = $this->reviewReadService->getReviews($this->max_review_count);

        //viewへ遷移
        return Inertia::render('Home/Index', compact(
            'newses',
            'rankings',
            'youtube_programs',
            'nicovideo_programs',
            'reviews',
        ));
    }
}
