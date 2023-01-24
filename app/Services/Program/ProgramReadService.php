<?php

namespace App\Services\Program;

use App\Models\Program;
use Illuminate\Database\Eloquent\Collection;

class ProgramReadService
{

    /**
     * コンストラクタ
     */
    function __construct(
        private Program $programModel,
    ) {
    }

    /**
     * 今週の動画ランキングを取得
     * 
     * @param int $count 取得する件数
     * 
     * @return Collection
     */
    public function getRanking(int $count) : Collection
    {
        return $this->programModel
            ->select(
                'programs.id as id',
                'programs.image_url as image_url',
                'programs.site_id as site_id',
                'programs.title as title',
                'programs.view_count',
                'programs.published_at as published_at',
                'creaters.user_icon_url as user_icon_url',
                'creaters.name as creater_name',
            )
            ->join('creaters', 'programs.creater_id', '=', 'creaters.id')
            ->where('published_at', '>=', date("Y-m-d H:i:s",strtotime("-1 year")))
            ->orderBy('view_count', 'DESC')
            ->limit($count)
            ->get();
    }
}