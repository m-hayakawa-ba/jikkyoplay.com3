<?php

namespace App\Services\Hard;

use App\Models\Hard;
use Illuminate\Database\Eloquent\Collection;

class HardReadService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private Hard $hardModel,
    ) {
    }

    /**
     * ハードのリストを取得
     */
    public function getHardList() : Collection
    {
        return $this->hardModel
            ->select(
                'id',
                'name',
            )
            ->where('flag_enabled', 1)
            ->orderBy('sort_id', 'asc')
            ->get();
    }
}