<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * カラムの設定
     */
    protected $fillable = [
        'program_id',
        'reviewer',
        'detail',
        'ip_address',
        'cookie_string',
    ];
    protected $hidden = [
        'ip_address',
        'cookie_string',
        'flag_enabled',
        'updated_at',
    ];

    /**
     * リレーションの定義
     */
    public function program(): object
    {
        return $this->belongsTo('App\Models\Program');
    }

    /**
     * スコープ
     * 一覧画面で必要なselectやjoin、whereをまとめて指定
     */
    public function scopeSelectIndex(Builder $query)
    {
        return $query->select(
                'reviews.id as id',
                'reviews.program_id',
                'reviews.reviewer',
                'reviews.detail',
                'reviews.created_at',
                'programs.title',
                'programs.image_url',
                'programs.view_count',
                'programs.published_at',
                'creaters.name as creater_name',
                'creaters.site_id',
                'creaters.user_icon_url',
            )
            ->join('programs', 'reviews.program_id', '=', 'programs.id')
            ->join('creaters', 'programs.creater_id', '=', 'creaters.id')
            ->where('reviews.flag_enabled', 1)
            ->where('programs.flag_enabled', 1);
    }
}
