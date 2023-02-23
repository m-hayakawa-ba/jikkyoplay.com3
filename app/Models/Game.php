<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    /**
     * リレーションの定義
     */
    public function game_search_names(): object
    {
        return $this->hasMany('App\Models\GameSearchName');
    }
}
