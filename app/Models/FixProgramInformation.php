<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixProgramInformation extends Model
{
    use HasFactory;
    protected $table = 'fix_program_infomations';

    /**
     * カラムの設定
     */
    protected $fillable = [
        'program_id',
        'old_game_id',
        'old_voice_id',
        'new_game_id',
        'new_voice_id',
        'ip_address',
    ];
}
