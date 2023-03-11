<?php

namespace App\Services\RecommendQuery;

use App\Models\RecommendQuery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RecommendQueryReadService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private RecommendQuery $recommendQueryModel,
    ) {
    }

    /**
     * おすすめリンクを取得
     */
    public function getRecommendQueries() : Collection
    {
        return $this->recommendQueryModel
            ->orderBy('sort_id', 'asc')
            ->get();
    }

    /**
     * おすすめリンクの中から、動画の検索結果一覧であるものを取得
     * 
     * @return array クエリストリングを連想配列に直したもの
     */
    public function getProgramRecommendQueries() : array
    {
        //おすすめリンクから遷移先のパスを取得
        $recommend_queries= $this->recommendQueryModel
            ->select('id', 'path')
            ->where('path', "like", "/program?%")
            ->orderBy('sort_id', 'asc')
            ->get();
        
        //パスを連想配列に変換
        $queries = [];
        foreach($recommend_queries as $recommend_query) {
            parse_str(
                str_replace("/program?", "", $recommend_query->path),
                $query
            );
            $queries[] = $query;
        }

        //連想配列を返す
        return $queries;
    }
}