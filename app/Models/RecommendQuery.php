<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecommendQuery extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * カラムの設定
     */
    public $timestamps = false;
    protected $fillable = [
        'name',
        'path',
        'sort_id',
    ];
    protected $hidden = [
        'sort_id',
        'deleted_at',
    ];

}
