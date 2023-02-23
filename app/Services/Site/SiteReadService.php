<?php

namespace App\Services\Site;

use App\Models\Site;
use Illuminate\Database\Eloquent\Collection;

class SiteReadService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private Site $siteModel,
    ) {
    }

    /**
     * サイトのリストを取得
     */
    public function getSiteList() : Collection
    {
        return $this->siteModel
            ->select(
                'id',
                'name'
            )
            ->orderBy('id', 'asc')
            ->get();
    }
}