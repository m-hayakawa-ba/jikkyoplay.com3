<?php

namespace App\Http\Controllers;

use App\Services\News\NewsReadService;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * 定数定義
     */
    private $max_news_count = 4;

    /**
     * コンストラクタ
     */
    public function __construct(
        private NewsReadService $newsReadService,
    ){
    }

    /**
     * トップページを表示
     */
    public function index()
    {
        //最新ニュースを取得
        $newses = $this->newsReadService->getNewsAtHome($this->max_news_count);

        //viewへ遷移
        return Inertia::render('Home/Index', compact(
            'newses'
        ));
    }
}
