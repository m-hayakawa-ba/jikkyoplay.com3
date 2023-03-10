<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchWord extends Model
{
    use HasFactory;

    /**
     * カラムの設定
     */
    protected $fillable = [
        'word',
        'point',
        'ip_address',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
