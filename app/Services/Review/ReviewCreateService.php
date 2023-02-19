<?php

namespace App\Services\Review;

use App\Models\Review;
use Illuminate\Support\Facades\Cookie ;

class ReviewCreateService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private Review $reviewModel,
    ) {
    }

    /**
     * 新しいレビューを作成する
     * 
     * @param int $program_id
     * @param string $reviewer
     * @param string $detail
     * 
     * @return ?Review
     */
    public function createReview(int $program_id, string $reviewer, string $detail) : ?Review
    {
        //IPアドレスを取得する
        $ip_address = $_SERVER["REMOTE_ADDR"];

        //ユーザーのcookieを作成・保存する
        $cookie_string = Cookie::get(
            'review_cookie_string',
            password_hash(time() . $ip_address, PASSWORD_DEFAULT),
        );
        Cookie::queue("review_cookie_string", $cookie_string, 60*24*365);

        //レビューを作成する
        $review = $this->reviewModel->create(compact(
            'program_id',
            'reviewer',
            'detail',
            'ip_address',
            'cookie_string',
        ));

        //作成したレビューを返して終了
        return $review;
    }
}