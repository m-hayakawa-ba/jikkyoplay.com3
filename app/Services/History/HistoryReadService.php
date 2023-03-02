<?php

namespace App\Services\History;

use App\Models\Program;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cookie;

class HistoryReadService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private Program $programModel,
    ) {
    }

    /**
     * cookieデータを取得する
     * 
     * @return Collection 動画の視聴履歴の連想配列
     */
    public function getHistory() : Collection
    {
        //cookieデータの取得
        $viewed =  json_decode(Cookie::get('history_viewed_at2'), true);

        //番組データを取得
        $programs = $this->programModel
            ->SelectIndex()
            ->whereIn('programs.id', array_keys($viewed))
            ->get();
        
        //視聴日の降順でソート
        $programs = $programs->sort(function ($a, $b) use ($viewed) {
            return $viewed[$a->id] > $viewed[$b->id] ? -1 : 1;
        });
        
        //結果を返す
        return $programs;
    }
}