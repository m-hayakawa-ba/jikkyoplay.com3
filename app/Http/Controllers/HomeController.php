<?php

namespace App\Http\Controllers;

use App\Libs\CacheLib;
use App\Services\News\NewsReadService;
use App\Services\Program\ProgramReadService;
use App\Services\RecommendQuery\RecommendQueryReadService;
use App\Services\Review\ReviewReadService;
use App\Services\SearchWord\SearchWordReadService;
use Inertia\Inertia;

class HomeController extends Controller
{
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
        $newses = CacheLib::remember('home_newses', function() use ($that) {
            return $that->newsReadService->getNewsAtHome(
                config('laravel.max_news_count')
            );
        });

        //今週のランキングを取得
        $rankings = CacheLib::remember('home_rankings', function() use ($that) {
            return $that->programReadService->getTotalRanking(
                config('laravel.max_ranking_count'),
                config('laravel.period_ranking'),
            );
        });

        //新着動画を取得
        $youtube_programs = CacheLib::remember('home_youtube_programs', function() use ($that) {
            return $that->programReadService->getLatestProgramsEverySite(
                config('laravel.max_program_count'),
                config('const.site.youtube'),
            );
        });
        $nicovideo_programs = CacheLib::remember('home_nicovideo_programs', function() use ($that) {
            return $that->programReadService->getLatestProgramsEverySite(
                config('laravel.max_program_count'),
                config('const.site.nicovideo'),
            );
        });

        //おすすめレビューを取得
        $reviews = CacheLib::remember('home_reviews', function() use ($that) {
            return $that->reviewReadService->getReviewsAtHome(
                config('laravel.max_review_count')
            );
        });

        //人気の検索ワードを取得
        $search_words = CacheLib::remember('home_search_words', function() use ($that) {
            return $that->searchWordReadService->getSearchWords(
                config('laravel.max_search_word'),
                config('laravel.period_search_word'),
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
