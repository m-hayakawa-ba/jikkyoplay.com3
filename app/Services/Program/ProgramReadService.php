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
            ->where('published_at', '>=', date("Y-m-d H:i:s",strtotime("-1 year")))
            ->orderBy('view_count', 'DESC')
            ->limit($count)
            ->get();
    }
}