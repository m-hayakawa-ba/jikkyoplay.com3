<?php

namespace App\Http\Controllers;

use App\Services\Program\ProgramSearchService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgramController extends Controller
{
    /**
     * 定数定義
     */
    private $get_program_count = 20; //1ページあたりの動画数

    /**
     * コンストラクタ
     */
    public function __construct(
        private ProgramSearchService $programSearchService,
    ){
    }

    /**
     * 動画一覧ページ
     * 
     * @param Request $request 検索やソートの条件
     */
    public function index(Request $request)
    {
        //動画を取得
        $array = $this->programSearchService->searchPrograms(
            $request,
            $this->get_program_count,
        );
        $count = $array['count'];
        $programs = $array['programs'];

        //ページネーションのためのページ番号を取得
        $page_current = $request->query('page', 1);
        $page_last    = $this->programSearchService->getMaxPageNumber(
            $count,
            $this->get_program_count,
        );

        //検索クエリを取得
        $queries = $request->all();

        //viewへ遷移
        return Inertia::render('Program/Index', compact(
            'count',
            'programs',
            'page_current',
            'page_last',
            'queries',
        ));
    }

    /**
     * 動画詳細ページ
     */
    public function show()
    {

    }
}
