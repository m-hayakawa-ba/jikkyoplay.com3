<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    /**
     * リレーションの定義
     */
    public function creater(): object
    {
        return $this->belongsTo('App\Models\Creater');
    }
    public function game(): object
    {
        return $this->belongsTo('App\Models\Game');
    }
    public function fix_program_information(): object
    {
        return $this->hasmany('App\Models\FixProgramInformation');
    }

    /**
     * スコープ
     * 一覧画面で必要なselectやjoin、whereをまとめて指定
     */
    public function scopeSelectIndex(Builder $query)
    {
        return $query->select(
                'programs.id as id',
                'programs.image_url as image_url',
                'programs.title as title',
                'programs.voice_id',
                'programs.view_count',
                'programs.published_at as published_at',
                'creaters.site_id as site_id',
                'creaters.user_icon_url as user_icon_url',
                'creaters.name as creater_name',
                'voices.type as voice_type',
            )
            ->join('creaters', 'programs.creater_id', '=', 'creaters.id')
            ->join('games', 'programs.game_id', '=', 'games.id')
            ->join('makers', 'games.maker_id', '=', 'makers.id')
            ->join('voices', 'programs.voice_id', '=', 'voices.id')
            ->where('flag_enabled', 1);
    }
    /**
     * スコープ
     * ソート順を設定する
     * 
     * @param string $sort
     * @param string $order
     */
    public function scopeSetOrderBy(Builder $query, string $sort, string $order)
    {
        return $query->orderBy(
            match($sort) {
                'view'    => 'programs.view_count',
                'sale'    => 'games.releace_year',
                default   => 'programs.published_at',
            },
            match($order) {
                'asc'     => 'asc',
                default   => 'desc',
            }
        );
    }
    /**
     * スコープ
     * レトロゲーのみをWhereする
     */
    public function scopeWhereRetro(Builder $query)
    {
        return $query->whereIn('games.hard_id', [
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
        ]);
    }
}
