<?php

namespace App\Services\History;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cookie;

class HistoryCreateService
{
    /**
     * cookieデータを保存する
     * 
     * @param int $program_id 動画のid
     */
    public function setHistory(int $program_id)
    {
        //cookieを読み込み
        $viewed = json_decode(Cookie::get('history_viewed_at2'), true);
        $viewed[$program_id] = date('U') + 9*60*60;

        //視聴日の降順でソート
        if ($viewed) {
            arsort($viewed);
        }
        
        //30個より多くなったときは、最後の要素を削除
        while(count($viewed) > 30) {
            array_pop($viewed);
        }

        //cookieを保存
        Cookie::queue("history_viewed_at2", json_encode($viewed), config('const.cookie_time'));
    }
}