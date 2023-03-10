<?php

namespace App\Libs;

/**
 * 検索用文字列を操作するライブラリ
 */
class SearchStringLib
{
    /**
     * 文字列に対して以下の操作を行います
     * ・全角スペースを半角スペースに変換します
     * ・連続した半角スペースを一つにまとめます
     * ・最初と最後に半角スペースがあった場合は除去します
     * 
     * @param string $str
     * 
     * @return string
     */
    public static function normalizeSpace(string $str) : string
    {
        //全角文字を半角文字に変換
        $str = mb_convert_kana($str, 'as');

        //連続する半角スペースを一つにまとめる
        $str = preg_replace('/\s+/', ' ', $str);

        //最初の半角スペースを除去
        $str = preg_replace('/^\s+/', '', $str);

        //最後の半角スペースを除去
        $str = preg_replace('/\s+$/', '', $str);

        //変換後の文字列を返す
        return $str;
    }
}