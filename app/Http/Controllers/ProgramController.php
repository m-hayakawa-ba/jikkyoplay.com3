<?php

namespace App\Http\Controllers;

use App\Services\Creater\CreaterReadService;
use App\Services\Game\GameReadService;
use App\Services\Program\ProgramReadService;
use App\Services\Program\ProgramSearchService;
use App\Services\Review\ReviewReadService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgramController extends Controller
{
    /**
     * 定数定義
     */
    private $get_program_count = 20;     //1ページあたりの動画数
    private $relation_program_count = 4; //表示させる関連動画の個数

    /**
     * コンストラクタ
     */
    public function __construct(
        private CreaterReadService   $createrReadService,
        private GameReadService      $gameReadService,
        private ProgramReadService   $programReadService,
        private ProgramSearchService $programSearchService,
        private ReviewReadService    $reviewReadService,
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

        //ゲーム情報を取得
        $game = $this->gameReadService->getGame($program->game_id);

        //レビューを取得
        $reviews = $this->reviewReadService->getProgramReviews($program_id);

        //関連動画を取得
        $relation_programs = $this->programReadService->getRelationPrograms(
            program_id: $program_id,
            game_id: $program->game_id,
            creater_id: $program->creater_id,
            count: $this->relation_program_count,
        );

        //viewへ遷移
        return Inertia::render('Program/Show', compact(
            'program',
            'creater',
            'game',
            'reviews',
            'relation_programs',
        ));
    }
}
