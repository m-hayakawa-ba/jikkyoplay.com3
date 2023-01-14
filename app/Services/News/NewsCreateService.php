<?php

namespace App\Services\News;

use App\Models\News;

class NewsCreateService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private News $newsModel,
    ) {
    }

    /**
     * 新しいニュースを作成する
     * 
     * @param string $title_and_author          GoogleNewsのRSSから取得した記事のタイトルとソースサイト名
     * @param string $published_at_unformatted  GoogleNewsのRSSから取得した記事の日時
     * @param string $url                       記事のソースURL
     * 
     * @return ?string 失敗した場合は理由を文字列で返す
     */
    public function createNews(string $title_and_author, string $published_at_unformatted, string $url) : ?string
    {
        //与えられた文字列をtitleとauthorに分割する
        $array = explode(" - ", $title_and_author);

        //もし3つ以上の配列に分割された場合はエラーを返す
        if (count($array) != 2) {
            return "GoogleNewaから取得した記事タイトルを、記事とサイト名に分割できませんでした";
        }
        $title  = $array[0];
        $author = $array[1];

        //日時をDBに入る文字列に変換する
        $published_at = date('Y-m-d H:i:s', strtotime($published_at_unformatted . ' +9 hours'));

        //DBにデータを入れていく
        $news = $this->newsModel->create(compact(
            'title',
            'author',
            'url',
            'published_at',
        ));

        //失敗したらエラーを返す
        if (is_null($news)) {
            return "GoogleNewsをデータベースに入れることができませんでした";
        }

        //終了したらnullを返す
        return null;
    }
}