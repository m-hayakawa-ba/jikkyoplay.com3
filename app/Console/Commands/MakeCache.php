<?php

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Libs\CacheLib;
use App\Services\Creater\CreaterReadService;
use App\Services\News\NewsReadService;
use App\Services\Program\ProgramReadService;
use App\Services\Program\ProgramSearchService;
use App\Services\RecommendQuery\RecommendQueryReadService;
use App\Services\Review\ReviewReadService;
use App\Services\SearchWord\SearchWordReadService;


class MakeCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a cache for faster loading';

    /**
     * 定数
     */
    private $sort = [
        'date',
        'view',
        'year',
    ];
    private $order = [
        'asc',
        'desc',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        private CreaterReadService $createrReadService,
        private NewsReadService $newsReadService,
        private ProgramReadService $programReadService,
        private RecommendQueryReadService $recommendQueryReadService,
        private ProgramSearchService    $programSearchService,
        private ReviewReadService $reviewReadService,
        private SearchWordReadService $searchWordReadService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //ログに出力
        Log::info("キャッシュの作成を開始します");

        //トップページのニュースのキャッシュを作成する
        CacheLib::put(
            'home_newses',
            $this->newsReadService->getNewsAtHome(
                config('laravel.max_news_count')
            ),
        );

        //トップページのランキングのキャッシュを作成する
        CacheLib::put(
            'home_rankings',
            $this->programReadService->getTotalRanking(
                config('laravel.max_ranking_count'),
                config('laravel.period_ranking'),
            ),
        );

        //トップページの新着動画のキャッシュを作成する
        CacheLib::put(
            'home_youtube_programs',
            $this->programReadService->getLatestProgramsEverySite(
                config('laravel.max_program_count'),
                config('const.site.youtube'),
            ),
        );
        CacheLib::put(
            'home_nicovideo_programs',
            $this->programReadService->getLatestProgramsEverySite(
                config('laravel.max_program_count'),
                config('const.site.nicovideo'),
            ),
        );

        //トップページのレビューのキャッシュを作成する
        CacheLib::put(
            'home_reviews',
            $this->reviewReadService->getReviewsAtHome(
                config('laravel.max_review_count')
            ),
        );

        //トップページの人気検索ワードのキャッシュを作成する
        CacheLib::put(
            'home_search_words',
            $this->searchWordReadService->getSearchWords(
                config('laravel.max_search_word'),
                config('laravel.period_search_word'),
            ),
        );

        //ランキング一覧のキャッシュを作成する
        CacheLib::put(
            'ranking_total_rankings',
            $this->programReadService->getTotalRanking(
                config('laravel.ranking_count'),
                config('laravel.ranking_period'),
            ),
        );
        CacheLib::put(
            'ranking_creater_rankings',
            $this->createrReadService->getRankings(
                config('laravel.ranking_count'),
                config('laravel.ranking_period'),
            ),
        );
        CacheLib::put(
            'ranking_female_rankings',
            $this->programReadService->getFemaleRanking(
                config('laravel.ranking_count'),
                config('laravel.ranking_period'),
            ),
        );
        CacheLib::put(
            'ranking_horror_rankings',
            $this->programReadService->getHorrorRanking(
                config('laravel.ranking_count'),
                config('laravel.ranking_period'),
            ),
        );
        CacheLib::put(
            'ranking_retro_rankings',
            $this->programReadService->getRetroRanking(
                config('laravel.ranking_count'),
                config('laravel.ranking_period'),
            ),
        );

        //動画一覧のキャッシュはおすすめクエリに含まれるので作成不要
        // foreach($this->sort as $sort) {
        //     foreach($this->order as $order) {
        //         $request = new Request();
        //         $request->merge([
        //             'sort'  => $sort,
        //             'order' => $order,
        //             'page'  => 1,
        //         ]);
        //         CacheLib::put(
        //             "program",
        //             $this->programSearchService->searchPrograms(
        //                 $request,
        //                 config('laravel.program_count'),
        //             ),
        //             $request->toArray()
        //         );
        //     }
        // }

        //おすすめクエリのキャッシュを作成する
        $recommend_queries = $this->recommendQueryReadService->getProgramRecommendQueries();
        foreach($recommend_queries as $recommend_query) {
            foreach($this->sort as $sort) {
                foreach($this->order as $order) {
                    $request = new Request();
                    $request->merge($recommend_query);
                    $request->merge([
                        'sort'  => $sort,
                        'order' => $order,
                        'page'  => 1,
                    ]);
                    CacheLib::put(
                        'program',
                        $this->programSearchService->searchPrograms(
                            $request,
                            config('laravel.program_count'),
                        ),
                        $request->toArray(),
                    );
                }
            }
        }

        //ログに出力
        Log::info("キャッシュの作成が終了しました");
    }
}
