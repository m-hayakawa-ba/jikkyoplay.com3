<?php

namespace App\Http\Controllers;

use App\Services\Review\ReviewCreateService;
use App\Services\Review\ReviewReadService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    /**
     * 定数定義
     */
    private $get_review_count = 10;     //1ページあたりのレビュー数

    /**
     * コンストラクタ
     */
    public function __construct(
        private ReviewCreateService $reviewCreateService,
        private ReviewReadService $reviewReadService,
    ){
    }

    /**
     * レビュー一覧
     */
    public function index(Request $request)
    {
        //レビュー一覧を取得
        $page = $request->query('page', 1);
        $reviews = $this->reviewReadService->getReviews(
            $page,
            $this->get_review_count,
        );

        //最大ページ数を取得
        $page_last = $this->reviewReadService->getMaxPageNumber($this->get_review_count);

        //viewへ遷移
        return Inertia::render('Review/Index', compact(
            'page',
            'page_last',
            'reviews',
        ));
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
