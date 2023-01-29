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
     * @param string $where 絞り込み条件
     *  'total'     総合ランキング
     *  'male'      男性実況者ランキング
     *  'female'    女性実況者ランキング
     *  'retro'     レトロゲームランキング
     * 
     * @return Collection
     */
    public function getRankings(int $count, string $where = 'total') : Collection
    {
        
        //検索条件を設定
        $programs = match($where) {
            'male'   => $this->programModel->where('programs.voice_id', config('const.male')),
            'female' => $this->programModel->where('programs.voice_id', config('const.female')),
            'retro'  => $this->programModel->whereIn('games.hard_id', [
                    
                ]),
            default  => $this->programModel,
        };

        $programs = $programs->orderBy('view_count', 'DESC')
            ->SelectIndex()
            ->where('published_at', '>=', date("Y-m-d H:i:s",strtotime("-1 year")))
            ->limit($count)
            ->get();
        
        return $programs;
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