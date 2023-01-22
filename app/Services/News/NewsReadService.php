<?php

namespace App\Services\News;

use App\Models\News;
use Illuminate\Database\Eloquent\Collection;

class NewsReadService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private News $newsModel,
    ) {
    }

    /**
     * 過去に同じニュースがないかどうか調べる
     * 
     * @param string $title 重複チェックをしたいニュースタイトル
     * @param string $published_at そのニュースの投稿日時
     * 
     * @return bool 重複していた場合はtrueを返す
     */
    public function isDuplicateNews(string $title, string $published_at) : bool
    {
        //重複チェックでとりあえず20文字目まで調べてみる
        $title = mb_substr($title, 0, 20);

        //重複するニュースタイトルがあるかどうか調べる
        $count = $this->newsModel
            ->where('title', 'LIKE', $title.'%')
            ->where('published_at', '<=', date("Y-m-d H:i:s", strtotime($published_at . " +3 day")))
            ->where('published_at', '>=', date("Y-m-d H:i:s", strtotime($published_at . " -3 day")))
            ->count();

        //重複する記事があった場合はtrueを返す
        return $count > 0 ? true : false;
    }

    /**
     * トップページに表示させる最新ニュースを取得
     * 
     * @param int $count 取得する件数
     * 
     * @return Collection
     */
    public function getNewsAtHome(int $count) : Collection
    {
        return $this->newsModel
            ->with('news_source')
            ->orderBy('published_at', 'desc')
            ->where('flag_enabled', 1)
            ->limit($count)
            ->get();
    }
}