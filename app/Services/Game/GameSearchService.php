<?php

namespace App\Services\Game;

use App\Models\Game;
use App\Libs\SearchStringLib;
use Illuminate\Database\Eloquent\Collection;

class GameSearchService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private Game $gameModel,
    ) {
    }

    /**
     * 与えられた文字列から該当するゲームリストを取得
     * 
     * @param string $search_word 検索文字列
     * 
     * @return Collection
     */
    public function searchGames(string $search_word) : Collection
    {
        //いくつまでリストを取得するか
        $count = 4;

        //検索ワードが完全一致したゲーム
        $match_games = $this->gameModel
            ->select(
                'games.id',
                'games.name',
                'games.hard_id',
                'hards.name as hard_name',
                'games.maker_id',
                'makers.name as maker_name',
                'games.releace_year',
            )
            ->join('makers', 'games.maker_id', '=', 'makers.id')
            ->join('hards', 'games.hard_id', '=', 'hards.id')
            ->where('games.name', $search_word)
            ->limit($count)
            ->get();
        
        //もし完全一致だけでリストが埋まったら
        if ($match_games->count() >= $count) {
            return $match_games;
        }
        
        //部分一致だったゲーム
        $semi_match_games = $this->gameModel
            ->select(
                'games.id',
                'games.name',
                'games.hard_id',
                'hards.name as hard_name',
                'games.maker_id',
                'makers.name as maker_name',
                'games.releace_year',
            )
            ->join('makers', 'games.maker_id', '=', 'makers.id')
            ->join('hards', 'games.hard_id', '=', 'hards.id')
            ->where('games.name', '!=', $search_word);
        $words = explode(" ", SearchStringLib::normalizeSpace($search_word));
        foreach($words as $word) {
            $semi_match_games = $semi_match_games->whereHas('game_search_names', function ($q) use ($word) {
                $q->where('search_name', 'like', '%' . $word . '%');
            });
        }
        $semi_match_games = $semi_match_games->inRandomOrder()
            ->limit($count - $match_games->count())
            ->get();

        //Collectionを合体させて返す
        return $match_games->merge($semi_match_games);
    }
}