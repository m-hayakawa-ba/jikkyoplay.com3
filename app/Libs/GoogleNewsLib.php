<?php

namespace App\Libs;

/**
 * googleニュースを取得するライブラリ
 */
class GoogleNewsLib
{
    //検索に使う文字列
    private static $needle = 'ゲーム実況';

    //googleニュースのrss取得url
    private static $url = "https://news.google.com/rss/search";

    /**
     * googleニュースを取得するためのURLを返す
     * 
     * @param ?string $after   期間指定（デフォルトは一日前）
     * @param ?string $before  期間指定（デフォルトは指定なし）
     * 
     * @return string         googleニュースを取得するためのURL
     */
    public static function getUrl( ?string $after, ?string $before ) : ?string
    {
        //検索文字列の作成
        $q = ($after ? "after:{$after}+" : "") . 
            ($before ? "before:{$before}+" : "") . 
            urlencode(self::$needle);

        //クエリストリングの作成
        $query_string = "?q={$q}&hl=ja&gl=JP&ceid=JP:ja";

        //URLを返す
        return self::$url . $query_string;
    }

    /**
     * googleニュースを取得する
     * 
     * @param ?string $after   期間指定（デフォルトは一日前）
     * @param ?string $before  期間指定（デフォルトは指定なし）
     * 
     * @return ?string        xml形式で取得したデータを返す　失敗時はnull
     */
    public static function getNews( ?string $after, ?string $before ) : ?string
    {
        //URLの作成
        $url = self::getUrl($after, $before);

        //curlの設定
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');   //リクエストのメソッド
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);   //リダイレクト先をたどるか
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);          //何回までリダイレクトをたどるか
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);      //リダイレクトの際にヘッダのRefererを自動的に追加
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  //サーバー証明書の検証を行わない
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  //よくわからないがチェックをゆるくしてエラー回避
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   //結果を文字列として受け取る

        //データを取得してcurlを終了
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);

        //エラーの場合はnullを返す
        if ($httpcode != 200) {
            return null;
        }

        //取得したデータを返す
        return $response;
    }
}