<?php

namespace App\Services\SearchWord;

use App\Models\SearchWord;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SearchWordReadService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private SearchWord $searchWordModel,
    ) {
    }

    /**
     * 人気の検索ワードを絞り込む
     * 
     * @param int $count 取得する検索ワード数
     * @param string $period 検索ワードの集計期間（strtotimeに渡せる形式で）
     * 
     * @return Collection
     */
    public function getSearchWords(int $count, string $period)
    {
        return $this->searchWordModel
            ->select(DB::raw('word, SUM(point) AS count'))
            ->where('created_at', '>=', date("Y-m-d H:i:s", strtotime($period)))
            ->groupBy('word')
            ->orderBy('count', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($count)
            ->get();
    }
}