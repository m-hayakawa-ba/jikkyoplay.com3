<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hard extends Model
{
    use HasFactory;

    /**
     * カラムの設定
     */
    protected $hidden = [
        'search_name',
        'sort_id',
        'flag_enabled',
        'created_at',
        'updated_at',
    ];
}
