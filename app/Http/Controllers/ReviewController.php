<?php

namespace App\Http\Controllers;

use App\Services\Review\ReviewCreateService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct(
        private ReviewCreateService $reviewCreateService,
    ){
    }

    /**
     * 新しいレビューを投稿
     */
    public function store(Request $request)
    {
        //レビューを作成する
        $review = $this->reviewCreateService->createReview(
            $request->program_id,
            $request->reviewer,
            $request->detail,
        );

        //失敗したら500を返す
        if (is_null($review)) {
            return response()->json('レビューの作成に失敗しました', 500);
        }

        //200を返して終了
        return response()->json($review->toArray(), 200);
    }
}
