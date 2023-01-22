<?php

namespace App\Services\News;

use App\Libs\HttpRequestLib;
use App\Models\News;
use App\Services\News\NewsReadService;
use App\Services\NewsSource\NewsSourceCreateService;
use Illuminate\Database\Eloquent\Collection;

class NewsCreateService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private News $newsModel,
        private NewsReadService $newsReadService,
        private NewsSourceCreateService $newsSourceCreateService,
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
        if (is_array($url)) {
            $url = $url[0];
        }

        //ニュースソースを作成
        $news_source = $this->newsSourceCreateService->createNewsSourceWhenNone($array[1], $url);

        //DBにデータを入れていく
        $news = $this->newsModel->create([
            'title' => $title,
            'news_source_id' => $news_source->id,
            'author' => '',
            'url' => $url,
            'image_url' => $this->getOgImageUrl($url),
            'published_at' => $published_at,
        ]);

        //失敗したらエラーを返す
        if (is_null($news)) {
            return "GoogleNewsをデータベースに入れることができませんでした";
        }

        //終了したらnullを返す
        return null;
    }

    /**
     * 与えられた外部urlのog:imageで指定された画像のurlを取得する
     * 
     * @param string $url 外部サイトのurl
     * 
     * @return ?string og:imageのurl
     */
    private function getOgImageUrl(string $url) : ?string
    {
        //外部urlのhtmlを取得する
        $html = HttpRequestLib::getHtmlCurl($url);
        $dom = new \DOMDocument;
        @$dom->loadHTML($html);
        
        //XPathでmetaタグのog:imageを取得
        $xpath = new \DOMXPath($dom);
        $node_image = $xpath->query('//meta[@property="og:image"]/@content');
        if ($node_image->length > 0) {
            $image_url = $node_image->item(0)->nodeValue;
            if (strlen($image_url) < 250) {
                return $image_url;
            }
        }

        //取得できなかった場合はnullを返す
        return null;
    }
}