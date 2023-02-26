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
}
