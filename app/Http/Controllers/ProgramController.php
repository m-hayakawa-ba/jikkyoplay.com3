<?php

namespace App\Http\Controllers;

use App\Services\Creater\CreaterReadService;
use App\Services\Program\ProgramReadService;
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
        private CreaterReadService   $createrReadService,
        private ProgramReadService   $programReadService,
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
        //ソート順がなかった場合は設定する
        if (!$request->has('sort')) {
            $request->merge(['sort' => 'date']);
        }
        if (!$request->has('order')) {
            $request->merge(['order' => 'desc']);
        }

        //動画を取得
        $array = $this->programSearchService->searchPrograms(
            $request,
            $this->get_program_count,
        );
        $count = $array['count'];
        $programs = $array['programs'];

        //ページネーションのためのページ番号を取得
        if (!$request->has('page')) {
            $request->merge(['page' => 1]);
        }
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
            'page_last',
            'queries',
        ));
    }

    /**
     * 動画詳細ページ
     */
    public function show(int $program_id, Request $request)
    {
        //動画情報を取得
        $program = $this->programReadService->getProgram($program_id);

        //投稿者情報を取得
        $creater = $this->createrReadService->getCreater($program->creater_id);

        //viewへ遷移
        return Inertia::render('Program/Show', compact(
            'program',
            'creater',
        ));
    }
}
