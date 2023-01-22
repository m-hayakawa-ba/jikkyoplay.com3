<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * カラムの設定
     */
    protected $fillable = [
        'title',
        'author',
        'news_source_id',
        'url',
        'image_url',
        'flag_enabled',
        'published_at',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'flag_enabled',
        'created_at',
        'updated_at',
    ];

    /**
     * リレーションの定義
     */
    public function news_source(): object
    {
        return $this->belongsTo('App\Models\NewsSource');
    }
}
