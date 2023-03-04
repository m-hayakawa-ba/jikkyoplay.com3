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
}