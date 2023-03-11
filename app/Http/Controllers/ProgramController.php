<?php

namespace App\Http\Controllers;

use App\Libs\CacheLib;
use Illuminate\Http\Request;
use App\Services\Creater\CreaterReadService;
use App\Services\Game\GameReadService;
use App\Services\Program\ProgramReadService;
use App\Services\Program\ProgramUpdateService;
use App\Services\Program\ProgramSearchService;
use App\Services\Review\ReviewReadService;
use App\Services\SearchWord\SearchWordCreateService;
use App\Services\History\HistoryCreateService;
use Inertia\Inertia;

class ProgramController extends Controller
{
    /**
     * 定数定義
     */
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
        //必要なパラメータがなかった場合は設定する
        if (!$request->filled('sort')) {
            $request->merge(['sort' => 'date']);
        }
        if (!$request->filled('order')) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->filled('page')) {
            $request->merge(['page' => 1]);
        }

        //キャッシュがあるかどうかを調べ、あるときだけ値を取得する
        $has_cache = CacheLib::has(
            'program',
            $request->toArray(),
        );
        if ($has_cache) {
            $array = CacheLib::get(
                'program',
                $request->toArray(),
            );
        } else {
            $array = $this->programSearchService->searchPrograms(
                $request,
                config('laravel.program_count'),
            );
        }
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
            config('laravel.program_count'),
        );

        //1ページあたりの動画数を取得
        $programs_per_page = config('laravel.program_count');

        //検索クエリを取得
        //array_filterを使っているのは、フロントでnullが文字列の"null"になってしまうのを防ぐため
        $queries = array_filter($request->all(), function ($value) {
            return $value !== null;
        });
        //point要素は次に引き継がない
        unset($queries['point']);

        //検索条件削除用の検索クエリを作成
        $delete_query_links = $this->programSearchService->getDeleteQueries($queries);

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
