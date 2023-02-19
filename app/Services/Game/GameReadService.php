<?php

namespace App\Services\Game;

use App\Models\Game;

class GameReadService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private Game $gameModel,
    ) {
    }

    /**
     * ゲーム情報を取得
     * 
     * @param int $game_id
     */
    public function getGame(int $game_id) : Game
    {
        return $this->gameModel
            ->select(
                'games.id as id',
                'games.name as name',
                'hards.id as hard_id',
                'hards.name as hard_name',
                'makers.id as maker_id',
                'makers.name as maker_name',
                'games.releace_year',
            )
            ->join('hards', 'games.hard_id', '=', 'hards.id')
            ->join('makers', 'games.maker_id', '=', 'makers.id')
            ->where('games.id', $game_id)
            ->first();
    }
}