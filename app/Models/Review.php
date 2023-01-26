<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * リレーションの定義
     */
    public function program(): object
    {
        return $this->belongsTo('App\Models\Program');
    }
}
