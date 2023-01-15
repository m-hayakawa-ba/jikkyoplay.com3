<?php

namespace App\Services\News;

use App\Models\News;
use App\Services\News\NewsReadService;
use Illuminate\Database\Eloquent\Collection;

class NewsCreateService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private News $newsModel,
        private NewsReadService $newsReadService,
    ) {
    }

    /**
     * 新しいニュースを作成する
     * 
     * @param string $title_and_author          GoogleNewsのRSSから取得した記事のタイトルとソースサイト名
     * @param string $published_at_unformatted  GoogleNewsのRSSから取得した記事の日時
     * @param string $source_url                記事のリダイレクト元URL
     * 
     * @return ?string 失敗した場合は理由を文字列で返す
     */
    public function createNews(string $title_and_author, string $published_at_unformatted, string $source_url) : ?string
    {
        //与えられた文字列をtitleとauthorに分割する
        $array = explode(" - ", $title_and_author);

        //もし3つ以上の配列に分割された場合はエラーを返す
        if (count($array) != 2) {
            return "GoogleNewaから取得した記事タイトルを、記事とサイト名に分割できませんでした";
        }
        $title  = $array[0];
        $author = $array[1];

        //タイトル中に「ゲーム」「実況」の2語がない場合はエラーを返す
        if (mb_strpos($title, 'ゲーム') === false || mb_strpos($title, '実況') === false) {
            return "ゲーム実況とは関係のない記事だったためスキップします";
        }

        //日時をDBに入る文字列に変換する
        $published_at = date('Y-m-d H:i:s', strtotime($published_at_unformatted . ' +9 hours'));

        //記事の重複チェック
        if ($this->newsReadService->isDuplicateNews($title, $published_at)) {
            return "重複だったので処理をスキップしました";
        }

        //リンクをリダイレクト先のURLに変換
        $url = get_headers($source_url, 1)['Location'];
        if (empty($url)) {
            return "リダイレクト先のURLを取得できませんでした";
        }

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