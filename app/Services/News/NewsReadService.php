<?php

namespace App\Services\News;

use App\Models\News;

class NewsReadService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private News $newsModel,
    ) {
    }
}