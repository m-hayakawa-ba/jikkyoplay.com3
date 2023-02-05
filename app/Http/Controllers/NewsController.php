<?php

namespace App\Http\Controllers;

use App\Services\News\NewsReadService;
use Inertia\Inertia;

class NewsController extends Controller
{
    /**
     * 定数定義
     */
    private $get_news_count = 20; //一度に取得するニュース数

    /**
     * コンストラクタ
     */
    public function __construct(
        private NewsReadService $newsReadService,
    ){
    }

    /**
     * ニュース一覧
     * 
     * @param string $month "2023-01" の形式で、年と月を渡す
     */
    public function index(string $month = null) {
       
        $month = $month ?? date("Y-m");
        $newses = $this->newsReadService->getNewsMonth($month);

        //viewへ遷移
        
        return Inertia::render('News/Index', compact(
            'month',
            'newses',
        ));
    }
}
