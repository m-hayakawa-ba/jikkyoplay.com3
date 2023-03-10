<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
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
        //クロージャに渡す用の変数を用意
        $that = $this;

        //おすすめリンクを取得
        $recommend_queries = $this->recommendQueryReadService->getRecommendQueries();

        //最新ニュースを取得
        $newses = Cache::remember('home_newses', 60*60, function() use ($that) {
            return $that->newsReadService->getNewsAtHome(
                $that->max_news_count
            );
        });

        //今週のランキングを取得
        $rankings = Cache::remember('home_rankings', 60*60, function() use ($that) {
            return $that->programReadService->getTotalRanking(
                $that->max_ranking_count,
                $that->period_ranking,
            );
        });

        //新着動画を取得
        $youtube_programs = Cache::remember('home_youtube_programs', 60*60, function() use ($that) {
            return $that->programReadService->getLatestProgramsEverySite(
                $that->max_program_count,
                config('const.site.youtube'),
            );
        });
        $nicovideo_programs = Cache::remember('home_nicovideo_programs', 60*60, function() use ($that) {
            return $that->programReadService->getLatestProgramsEverySite(
                $that->max_program_count,
                config('const.site.nicovideo'),
            );
        });

        //おすすめレビューを取得
        $reviews = Cache::remember('home_reviews', 60*60, function() use ($that) {
            return $that->reviewReadService->getReviewsAtHome(
                $that->max_review_count
            );
        });

        //人気の検索ワードを取得
        $search_words = Cache::remember('home_search_words', 60*60, function() use ($that) {
            return $that->searchWordReadService->getSearchWords(
                $that->max_search_word,
                $that->period_search_word,
            );
        });

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
