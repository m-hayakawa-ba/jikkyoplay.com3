<?php

namespace App\Services\NewsSource;

use App\Libs\HttpRequestLib;
use App\Models\NewsSource;
use Illuminate\Database\Eloquent\Collection;

class NewsSourceCreateService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private NewsSource $newsSourceModel,
    ) {
    }

    /**
     * ニュースソースの重複をチェックし、なかった場合は作成
     * 
     * @param string $name ニュースソースのサイト名
     * @param string $url  ニュースソースのurl
     * 
     * @return NewsSource 作成した（または見つかった）ニュースソース
     */
    public function createNewsSourceWhenNone(string $name, string $url) : NewsSource
    {
        //ニュースソースを取得する
        $news_source = $this->newsSourceModel
            ->where('name', $name)
            ->first();
        
        //取得できなかった場合はニュースソースを作成する
        if (is_null($news_source)) {

            //faviconのurlを取得する
            $favicon_url = $this->getFaviconUrl($url);

            //ニュースソースを作成する
            $news_source = $this->newsSourceModel->create([
                'name' => $name,
                'favicon_url' => $favicon_url ?? '',
            ]);
        }

        //作成したニュースソースを返却して終了
        return $news_source;
    }

    /**
     * 与えられた外部urlのfaviconのurlを取得する
     * 
     * @param string $url 外部サイトのurl
     * 
     * @return ?string faviconのurl
     */
    private function getFaviconUrl(string $url) : ?string
    {
        //まず、素直にファビコンのurlを作成してみる
        $parsed_url = parse_url($url);
        $favicon_url = 'https://' . $parsed_url['host'] . '/favicon.ico';

        //作成したステータスコードが200を返す場合、それを返却する
        if (HttpRequestLib::isStatus200($favicon_url)) {
            return $favicon_url;
        }
        
        //外部urlのhtmlを取得する
        $html = HttpRequestLib::getHtmlCurl($url);
        $dom = new \DOMDocument;
        @$dom->loadHTML($html);

        //XPathでファビコンのurlを取得
        $xpath = new \DOMXPath($dom);
        $favicon_url = $xpath->query('//link[@rel="icon"]/@href');
        if ($favicon_url->length > 0) {
            return $this->makeAbsolutepath(
                $favicon_url->item(0)->nodeValue,
                'https://' . $parsed_url['host']
            );
        }

        //取得できなかった場合は別の書き方を試す
        $favicon_url = $xpath->query('//link[@rel="shortcut icon"]/@href');
        if ($favicon_url->length > 0) {
            return $this->makeAbsolutepath(
                $favicon_url->item(0)->nodeValue,
                'https://' . $parsed_url['host']
            );
        }

        //だめだった場合はnullを返す
        return null;
    }

    /**
     * 与えられたurlが相対パスだった場合、絶対パスに直す
     * 
     * @param string $url 与えられたurl
     * @param string $host スキーマとホスト（スラッシュなし）
     * 
     * @return string 絶対パスのurl
     */
    private function makeAbsolutepath(string $url, string $host) : string
    {
        //与えられたurlが相対パスかどうか調べる
        $parsed_url = parse_url($url);

        //相対パスだった場合は絶対パスに直す
        if (
            !isset($parsed_url['scheme'])
            || !isset($parsed_url['host'])
        ) {
            return $host . $url;
        } else {
            return $url;
        }
    }
}