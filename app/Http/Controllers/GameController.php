<?php

namespace App\Http\Controllers;

use App\Services\Game\GameSearchService;
use App\Services\Program\ProgramUpdateService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * コンストラクタ
     */
    function __construct(
        private GameSearchService $gameSearchService,
        private ProgramUpdateService $programUpdateService,
    ) {
    }

    /**
     * ゲームリストの検索
     */
    public function search (Request $request)
    {
        //該当するゲームのリストを取得する
        $games = $this->gameSearchService->searchGames($request->game_search_name);

        //取得できなかったときはエラーを返す
        if ($games->count() == 0) {
            return response()->json('ゲームが見つかりませんでした', 500);
        }

        //取得できたときはリストを返す
        return response()->json($games->toArray(), 200);
    }

    /**
     * ゲーム情報の修正
     */
    public function update (int $program_id, Request $request)
    {
        //該当するゲーム情報を更新する
        $is_updated = $this->programUpdateService->updateProgram(
            $program_id,
            ['game_id' => $request->game_id],
        );

        //更新に失敗した場合
        if (!$is_updated) {
            return response()->json('情報の更新に失敗しました', 500);
        }

        //200を返して終了
        return response()->json([], 200);
    }
}
