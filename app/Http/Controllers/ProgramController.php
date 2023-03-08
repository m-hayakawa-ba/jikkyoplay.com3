<?php

namespace App\Http\Controllers;

use App\Services\Creater\CreaterReadService;
use App\Services\Game\GameReadService;
use App\Services\Program\ProgramReadService;
use App\Services\Program\ProgramUpdateService;
use App\Services\Program\ProgramSearchService;
use App\Services\Review\ReviewReadService;
use App\Services\SearchWord\SearchWordCreateService;
use App\Services\History\HistoryCreateService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgramController extends Controller
{
    /**
     * 定数定義
     */
    private $get_program_count = 24;          //1ページあたりの動画数
    private $relation_program_count = 6;      //表示させる関連動画の個数
    private $period_search_word = '-1 week';  //表示させる検索ワードの集計期間

    /**
     * コンストラクタ
     */
    public function __construct(
        private CreaterReadService      $createrReadService,
        private GameReadService         $gameReadService,
        private ProgramReadService      $programReadService,
        private ProgramUpdateService    $programUpdateService,
        private ProgramSearchService    $programSearchService,
        private ReviewReadService       $reviewReadService,
        private SearchWordCreateService $searchWordCreateService,
        private HistoryCreateService    $historyCreateService,
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
        if (!$request->filled('sort')) {
            $request->merge(['sort' => 'date']);
        }
        if (!$request->filled('order')) {
            $request->merge(['order' => 'desc']);
        }

        //動画を取得
        $array = $this->programSearchService->searchPrograms(
            $request,
            $this->get_program_count,
        );
        $count = $array['count'];
        $programs = $array['programs'];

        //検索履歴を保存
        if (!empty($request->word) && $request->has('point') && $request->point <= 4) {
            $this->searchWordCreateService->createSearchWord(
                $request->word,
                $request->point,
                $this->period_search_word,
            );
        }

        //ページネーションのためのページ番号を取得
        if (!$request->filled('page')) {
            $request->merge(['page' => 1]);
        }
        $page_last    = $this->programSearchService->getMaxPageNumber(
            $count,
            $this->get_program_count,
        );

        //1ページあたりの動画数を取得
        $programs_per_page = $this->get_program_count;

        //検索クエリを取得
        //array_filterを使っているのは、フロントでnullが文字列の"null"になってしまうのを防ぐため
        $queries = array_filter($request->all(), function ($value) {
            return $value !== null;
        });

        //検索条件削除用の検索クエリを作成
        $delete_query_links = $this->programSearchService->getDeleteQueries($request);

        //viewへ遷移
        return Inertia::render('Program/Index', compact(
            'count',
            'programs',
            'page_last',
            'programs_per_page',
            'queries',
            'delete_query_links',
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

        //視聴した動画をcookieに保存
        $this->historyCreateService->setHistory($program_id);

        //viewへ遷移
        return Inertia::render('Program/Show', compact(
            'program',
            'creater',
            'game',
            'reviews',
            'relation_programs',
        ));
    }

    /**
     * 動画の音声情報の修正
     */
    public function updateVoice(int $program_id, Request $request)
    {
        //動画の音声情報を更新する
        $is_success = $this->programUpdateService->updateVoiceId(
            program_id: $program_id,
            creater_id: $request->creater_id,
            voice_id:   $request->voice_id,
            all_flag:   $request->all_flag,
            ip_address: $request->ip(),
        );

        //失敗したら500を返す
        if (!$is_success) {
            return response()->json('情報の更新に失敗しました', 500);
        }

        //200を返して終了
        return response()->json([], 200);
    }

    /**
     * 動画のゲーム情報の修正
     */
    public function updateGame(int $program_id, Request $request)
    {
        //該当するゲーム情報を更新する
        $is_updated = $this->programUpdateService->updateGameId(
            $program_id,
            $request->game_id,
            ip_address: $request->ip(),
        );

        //失敗したら500を返す
        if (!$is_updated) {
            return response()->json('情報の更新に失敗しました', 500);
        }

        //200を返して終了
        return response()->json([], 200);
    }
}
