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
        'url',
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
}
