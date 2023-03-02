<?php

namespace App\Http\Controllers;

use App\Services\History\HistoryReadService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct(
        private HistoryReadService $historyReadService,
    ){
    }

    /**
     * 視聴履歴ページを表示
     */
    public function index()
    {
        //視聴した動画idを取得
        $programs = $this->historyReadService->getHistory();

        //viewへ遷移
        return Inertia::render('History/Index', compact(
            'programs'
        ));
    }
}
