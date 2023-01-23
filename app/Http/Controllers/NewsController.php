<?php

namespace App\Http\Controllers;

use App\Services\News\NewsReadService;
use Inertia\Inertia;

class NewsController extends Controller
{

    /**
     * コンストラクタ
     */
    public function __construct(
        private NewsReadService $newsReadService,
    ){
    }

    /**
     * ニュース一覧
     */
    public function index() {
       
        $newses = [];

        //viewへ遷移
        return Inertia::render('News/Index', compact(
            'newses'
        ));
    }
}
