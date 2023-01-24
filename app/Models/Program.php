<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    /**
     * リレーションの定義
     */
    public function creater(): object
    {
        return $this->belongsTo('App\Models\Creater');
    }
}
