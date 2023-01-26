<?php

namespace App\Services\Review;

use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ReviewReadService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private Review $reviewModel,
    ) {
    }

    /**
     * レビューを取得
     * 
     * @param int $count 取得する件数
     * 
     * @return Collection
     */
    public function getReviews(int $count) : Collection
    {
        return $this->reviewModel
            ->select(
                'reviews.id as id',
                'reviews.program_id',
                'reviews.reviewer',
                'reviews.detail',
                'reviews.displayed_at',
                'programs.title',
                'programs.image_url',
            )
            ->join('programs', 'reviews.program_id', '=', 'programs.id')
            ->where('reviews.flag_enabled', 1)
            ->where('programs.flag_enabled', 1)
            ->orderBy('displayed_at', 'desc')
            ->limit($count)
            ->get();
    }
}