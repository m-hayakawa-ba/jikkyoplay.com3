<?php

namespace App\Services\Program;

use App\Models\Program;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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
    public function getRankings(int $count) : Collection
    {
        return $this->programModel
            ->SelectIndex()
            ->where('published_at', '>=', date("Y-m-d H:i:s",strtotime("-1 year")))
            ->orderBy('view_count', 'DESC')
            ->limit($count)
            ->get();
    }

    /**
     * 指定した動画サイトの新着動画を新着で取得
     * 同じ日に投稿されたものは再生回数の多い順にする
     * 
     * @param int $count 取得する件数
     * @param int $site_id 取得する動画サイト
     */
    public function getLatestProgramsEverySite(int $count, int $site_id) : Collection
    {
        return $this->programModel
            ->SelectIndex()
            ->where('site_id', $site_id)
            ->orderBy(DB::raw("DATE_FORMAT(published_at,'%Y%m%d')"), 'desc')
            ->orderBy('view_count', 'desc')
            ->limit($count)
            ->get();
    }
}