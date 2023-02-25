<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Creater extends Model
{
    use HasFactory;

    /**
     * リレーションの定義
     */
    public function programs(): object
    {
        return $this->hasMany('App\Models\Program');
    }

    /**
     * スコープ
     * 一覧画面で必要なselectやjoinをまとめて指定
     */
    public function scopeSelectIndex(Builder $query)
    {
        return $query
            ->select(
                'creaters.id as id',
                'creaters.name as name',
                'creaters.site_id',
                'creaters.user_id',
                'creaters.user_icon_url',
            );
    }
}
