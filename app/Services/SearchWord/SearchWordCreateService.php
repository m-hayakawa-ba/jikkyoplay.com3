<?php

namespace App\Services\SearchWord;

use App\Models\SearchWord;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SearchWordCreateService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private SearchWord $searchWordModel,
    ) {
    }

    /**
     * 検索履歴を保存する
     * 
     * @param string $search_word 検索ワード
     * @param int $point ポイント
     * @param string $period 指定した期間内に検索ワードがあった場合は保存しない
     */
    public function createSearchWord(string $search_word, int $point, string $period)
    {
        //IPアドレスを保存
        $ip_address = $_SERVER["REMOTE_ADDR"];

        //検索ワードとポイントを分割する
        $words = explode(" ", mb_convert_kana($search_word, 'as'));
        $point = count($words) > 0
            ? floor($point / count($words))
            : 0;

        //pointが0のときは保存しない
        if ($point == 0) {
            return;
        }

        //検索ワードをDBに保存する
        foreach($words as $word) {

            //その検索ワードがそのIPでまだ検索されていないとき
            $search_word_count = $this->searchWordModel
                ->where('word', $word)
                ->where('ip_address', $ip_address)
                ->where('created_at', '>=', date("Y-m-d H:i:s", strtotime($period)))
                ->count();
        
            //検索されていなかった場合は保存する
            if ($search_word_count == 0) {

                //保存する
                $this->searchWordModel->create(compact(
                    'word',
                    'point',
                    'ip_address',
                ));
            }
        }
    }
}