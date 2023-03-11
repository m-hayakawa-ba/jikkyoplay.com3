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
            ->select(
                'programs.id as id',
                'programs.creater_id as creater_id',
                'programs.image_url as image_url',
                'programs.title as title',
                'programs.movie_id as movie_id',
                'programs.game_id',
                'programs.voice_id',
                'programs.view_count',
                'programs.published_at as published_at',
                'creaters.site_id as site_id',
                'creaters.user_icon_url as user_icon_url',
                'creaters.name as creater_name',
                'voices.type as voice_type',
            )
            ->join('creaters', 'programs.creater_id', '=', 'creaters.id')
            ->join('voices', 'programs.voice_id', '=', 'voices.id')
            ->where('programs.id', $program_id)
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
            ->WhereRetro()
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

    /**
     * ある動画の関連動画を取得
     * 
     * @param int $program_id 元の動画のprogram_id
     * @param int $game_id 元の動画のgame_id
     * @param int $creater_id 元の動画の投稿者id
     * @param int $count 取得する関連動画の個数
     * 
     * @return Collection
     */
    public function getRelationPrograms(int $program_id, int $game_id, int $creater_id, int $count) : Collection
    {
        return $this->programModel
            ->SelectIndex()
            ->addSelect(DB::raw("
                CASE
                    WHEN programs.creater_id = {$creater_id} THEN 1
                    ELSE 0
                END AS creater_match_flag
            "))
            ->where('programs.id', '!=', $program_id)
            ->where(function ($query) use ($game_id, $creater_id) {
                $query->where('programs.game_id', $game_id)
                      ->orWhere('programs.creater_id', $creater_id);
            })
            ->orderBy('creater_match_flag',  'DESC')
            ->orderBy('programs.view_count', 'DESC')
            ->limit($count)
            ->get();
    }

    /**
     * サイトマップに掲載する動画のidを取得
     * 
     * @return array
     */
    public function getSitemapPrograms() : array
    {
        return $this->programModel
            ->select('id')
            ->where('flag_enabled', 1)
            ->whereHas('reviews')
            ->orWhere('view_count', '>=', 100)
            ->orderBy('published_at', 'desc')
            ->limit(10000)
            ->get()
            ->toArray();
    }
}