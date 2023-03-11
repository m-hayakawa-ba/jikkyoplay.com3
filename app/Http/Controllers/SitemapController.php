<?php

namespace App\Http\Controllers;

use App\Services\News\NewsReadService;
use App\Services\Program\ProgramReadService;
use App\Services\RecommendQuery\RecommendQueryReadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct(
        private NewsReadService $newsReadService,
        private ProgramReadService $programReadService,
        private RecommendQueryReadService $recommendQueryReadService,
    ){
    }

    /**
     * サイトマップの表示
     */
    public function index(Request $request)
    {
        $sitemap = App::make("sitemap");

        //固定ページを作成
        $sitemap->add(URL::to('/'),        now(), '1.0', 'always');
        $sitemap->add(URL::to('/about'),   now(), '0.8', 'always');
        $sitemap->add(URL::to('/ranking'), now(), '0.8', 'always');
        $sitemap->add(URL::to('/program'), now(), '0.8', 'always');
        $sitemap->add(URL::to('/review'),  now(), '0.8', 'always');
        $sitemap->add(URL::to('/history'), now(), '0.2', 'always');

        //ゲーム実況ニュース
        $news_months = $this->newsReadService->getSitemapParameters();
        foreach($news_months as $news_month) {
            $sitemap->add(URL::to("/news/{$news_month['published_month']}"), now(), '0.4', 'always');
        }

        //おすすめ動画一覧
        $recommend_queries = $this->recommendQueryReadService->getRecommendQueries();
        foreach($recommend_queries as $recommend_query) {
            $sitemap->add(URL::to($recommend_query->path), now(), '0.6', 'always');
        }
        
        //その他動画個別ページ
        $programs = $this->programReadService->getSitemapPrograms();
        foreach($programs as $program) {
            $sitemap->add(URL::to('/program/' . $program['id']), now(), '0.6', 'always');
        }

        //xmlを出力
        return $sitemap->render('xml');
    }
}
