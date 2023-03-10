<?php

namespace App\Http\Controllers;

use App\Services\News\NewsReadService;
use App\Services\Program\ProgramReadService;
use App\Services\RecommendQuery\RecommendQueryReadService;
use App\Services\Review\ReviewReadService;
use App\Services\SearchWord\SearchWordReadService;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * 定数定義
     */
    private $max_news_count     = 6;          //表示させる最新ニュース
    private $max_ranking_count  = 3;          //表示させるランキング
    private $period_ranking     = '-1 week';  //表示させるランキングの集計期間
    private $max_program_count  = 3;          //サイトごとの表示させる新着動画
    private $max_review_count   = 2;          //表示させるレビュー数
    private $max_search_word    = 20;         //表示させる検索ワードの数
    private $period_search_word = '-1 week';  //表示させる検索ワードの集計期間

    /**
     * コンストラクタ
     */
    public function __construct(
        private NewsReadService $newsReadService,
        private ProgramReadService $programReadService,
        private RecommendQueryReadService $recommendQueryReadService,
        private ReviewReadService $reviewReadService,
        private SearchWordReadService $searchWordReadService,
    ){
    }

    /**
     * トップページを表示
     */
    public function index()
    {
        //おすすめリンクを取得
        $recommend_queries = $this->recommendQueryReadService->getRecommendQueries();

        //最新ニュースを取得
        $newses = $this->newsReadService->getNewsAtHome(
            $this->max_news_count
        );

        //今週のランキングを取得
        $rankings = $this->programReadService->getTotalRanking(
            $this->max_ranking_count,
            $this->period_ranking,
        );

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
        $reviews = $this->reviewReadService->getReviewsAtHome(
            $this->max_review_count
        );

        //人気の検索ワードを取得
        $search_words = $this->searchWordReadService->getSearchWords(
            $this->max_search_word,
            $this->period_search_word,
        );

        //viewへ遷移
        return Inertia::render('Home/Index', compact(
            'recommend_queries',
            'newses',
            'rankings',
            'youtube_programs',
            'nicovideo_programs',
            'reviews',
            'search_words',
        ));
    }
}
