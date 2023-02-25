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
     * 投稿者の詳細情報を取得
     * 
     * @param int $creater_id
     * 
     * @return Creater
     */
    public function getCreater(int $creater_id) : Creater
    {
        return $this->createrModel
            ->SelectIndex()
            ->addSelect(
                'sites.id as site_id',
                'sites.name as site_name',
            )
            ->join('sites', 'creaters.site_id', '=', 'sites.id')
            ->where('creaters.id', $creater_id)
            ->first();
    }

    /**
     * 投稿者のランキングを取得
     * 
     * @param int $count 取得する件数
     * @param string $period 取得する期間（strtotimeに渡せる形式で）
     * 
     * @return Collection
     */
    public function getRankings(int $count, string $period) : Collection
    {
        return $this->createrModel
            ->SelectIndex()
            ->selectRaw('SUM(programs.view_count) as view_count')
            ->join('programs', 'creaters.id', '=', 'programs.creater_id')
            ->whereNotNull('creaters.user_icon_url')
            ->where('programs.published_at', '>=', date("Y-m-d H:i:s", strtotime($period)))
            ->groupBy('creaters.id')
            ->orderBy('view_count', 'desc')
            ->limit($count)
            ->get();
    }
}