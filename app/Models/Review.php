<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * カラムの設定
     */
    protected $hidden = [
        'ip_address',
        'cookie_string',
        'flag_enabled',
        'created_at',
        'updated_at',
    ];

    /**
     * リレーションの定義
     */
    public function program(): object
    {
        return $this->belongsTo('App\Models\Program');
    }
}
