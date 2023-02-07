<?php

namespace App\Services\Creater;

use App\Models\Creater;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CreaterReadService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private Creater $createrModel,
    ) {
    }

    /**
     * 配信者のランキングを取得
     * 
     * @param int $count 取得する件数
     * @param string $period 取得する期間（strtotimeに渡せる形式で）
     * 
     * @return Collection
     */
    public function getRankings(int $count, string $period) : Collection
    {
        return $this->createrModel
            ->select(
                'creaters.id',
                'creaters.name',
                'creaters.site_id',
                'creaters.user_id',
                'creaters.user_icon_url',
            )
            ->selectRaw('SUM(programs.view_count) as view_count')
            ->join('programs', 'creaters.id', '=', 'programs.creater_id')
            ->where('programs.published_at', '>=', date("Y-m-d H:i:s", strtotime($period)))
            ->groupBy('creaters.id')
            ->orderBy('view_count', 'desc')
            ->limit($count)
            ->get();
    }
}