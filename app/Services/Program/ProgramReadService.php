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
     * 動画の詳細データを取得
     * 
     * @param int $program_id
     * 
     * @return Program
     */
    public function getProgram(int $program_id) : Program
    {
        return $this->programModel
            ->where('id', $program_id)
            ->first();
    }

    /**
     * 今週の総合ランキングを取得
     * 
     * @param int $count 取得する件数
     * @param string $period 取得する期間（strtotimeに渡せる形式で）
     * 
     * @return Collection
     */
    public function getTotalRanking(int $count, string $period) : Collection
    {
        return $this->programModel
            ->SelectIndex()
            ->where('published_at', '>=', date("Y-m-d H:i:s", strtotime($period)))
            ->orderBy('view_count', 'DESC')
            ->limit($count)
            ->get();
    }

    /**
     * 今週の女性実況ランキングを取得
     * 
     * @param int $count 取得する件数
     * @param string $period 取得する期間（strtotimeに渡せる形式で）
     * 
     * @return Collection
     */
    public function getFemaleRanking(int $count, string $period) : Collection
    {
        return $this->programModel
            ->SelectIndex()
            ->where('published_at', '>=', date("Y-m-d H:i:s", strtotime($period)))
            ->where('programs.voice_id', config('const.voice.female'))
            ->orderBy('view_count', 'DESC')
            ->limit($count)
            ->get();
    }

    /**
     * 今週のホラー実況ランキングを取得
     * 
     * @param int $count 取得する件数
     * @param string $period 取得する期間（strtotimeに渡せる形式で）
     * 
     * @return Collection
     */
    public function getHorrorRanking(int $count, string $period) : Collection
    {
        return $this->programModel
            ->SelectIndex()
            ->where('published_at', '>=', date("Y-m-d H:i:s", strtotime($period)))
            ->where('programs.title', 'like', '%ホラー%')
            ->orderBy('view_count', 'DESC')
            ->limit($count)
            ->get();
    }

    /**
     * 今週のレトロゲーム実況ランキングを取得
     * 
     * @param int $count 取得する件数
     * @param string $period 取得する期間（strtotimeに渡せる形式で）
     * 
     * @return Collection
     */
    public function getRetroRanking(int $count, string $period) : Collection
    {
        return $this->programModel
            ->SelectIndex()
            ->where('published_at', '>=', date("Y-m-d H:i:s", strtotime($period)))
            ->whereIn('games.hard_id', [
                config('const.hard.famicom'),
                config('const.hard.disk_system'),
                config('const.hard.super_famicon'),
                config('const.hard.mega_drive'),
                config('const.hard.pc_engine'),
                config('const.hard.game_boy'),
                config('const.hard.game_boy_color'),
                config('const.hard.virtual_boy'),
                config('const.hard.game_boy_advance'),
                config('const.hard.wonder_swan'),
                config('const.hard.game_gear'),
            ])
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
            ->where('creaters.site_id', $site_id)
            ->orderBy(DB::raw("DATE_FORMAT(published_at,'%Y%m%d')"), 'desc')
            ->orderBy('view_count', 'desc')
            ->limit($count)
            ->get();
    }
}