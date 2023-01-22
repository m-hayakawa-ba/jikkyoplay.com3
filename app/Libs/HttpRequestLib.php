<?php

namespace App\Libs;

/**
 * 外部urlに対してリクエストを送信するライブラリ
 */
class HttpRequestLib
{
    /**
     * 外部urlに対してcurlでhtmlを受信する
     * 
     * @param string $url
     * 
     * @return string
     */
    public static function getHtmlCurl(string $url) : string
    {
        //curlを使ってhtmlを受信する
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $html = curl_exec($ch);
        curl_close($ch);

        //受信したhtmlを返す
        return $html;
    }

    /**
     * 外部urlがステータスコード200を返すかどうか調べる
     * 
     * @param string $url
     * 
     * @return bool
     */
    public static function isStatus200(string $url) : bool
    {
        $headers = get_headers($url);
        $status_code = substr($headers[0], 9, 3);
        return $status_code == 200;
    }
}