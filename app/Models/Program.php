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
            ->where('flag_enabled', 1);
    }
}
