<?php

namespace App\Services\Voice;

use App\Models\Voice;
use Illuminate\Database\Eloquent\Collection;

class VoiceReadService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private Voice $voiceModel,
    ) {
    }

    /**
     * 声のリストを取得
     */
    public function getVoiceList() : Collection
    {
        return $this->voiceModel
            ->select(
                'id',
                'type'
            )
            ->orderBy('sort_id', 'asc')
            ->get();
    }
}