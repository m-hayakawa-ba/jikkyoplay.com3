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
                'programs.view_count',
                'programs.published_at as published_at',
                'creaters.site_id as site_id',
                'creaters.user_icon_url as user_icon_url',
                'creaters.name as creater_name',
            )
            ->join('creaters', 'programs.creater_id', '=', 'creaters.id')
            ->join('games', 'programs.game_id', '=', 'games.id')
            ->join('makers', 'games.maker_id', '=', 'makers.id')
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
}
