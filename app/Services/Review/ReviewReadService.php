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
     * トップ画面表示用のレビューを取得
     * 
     * @param int $count 取得する件数
     * 
     * @return Collection
     */
    public function getReviewsAtHome(int $count) : Collection
    {
        return $this->reviewModel
            ->SelectIndex()
            ->orderBy('reviews.created_at', 'desc')
            ->limit($count)
            ->get();
    }

    /**
     * 一覧画面表示用のレビューを取得
     * 
     * @param int $page ページ番号
     * @param int $count ページあたりの表示件数
     * 
     * @return Collection
     */
    public function getReviews(int $page, int $count) : Collection
    {
        //必要なselectとwhereなどを設定
        $reviews = $this->reviewModel
            ->SelectIndex()
            ->orderBy('reviews.created_at', 'desc');

        //取得個数を設定してデータを取得する
        $reviews = $reviews->limit($count)
            ->offset(($page - 1) * $count)
            ->get();
        
        //結果を返して終了
        return $reviews;
    }

    /**
     * ページネーションの最大ページ番号を返却する
     * 
     * @param int $per_page 1ページあたりの要素数
     * 
     * @return int 最大ページ番号
     */
    public function getMaxPageNumber(int $per_page) : int
    {
        //最大レビュー数を取得
        $max_item = $this->reviewModel
            ->SelectIndex()
            ->count();

        //最大ページ数を返す
        return ceil($max_item / $per_page);
    }

    /**
     * 動画詳細画面用のレビューを取得
     * 
     * @param int $program_id
     * 
     * @return Collection
     */
    public function getProgramReviews (int $program_id) : Collection
    {
        return $this->reviewModel
            ->where('program_id', $program_id)
            ->where('flag_enabled', 1)
            ->orderBy('reviews.created_at', 'desc')
            ->get();
    }
}