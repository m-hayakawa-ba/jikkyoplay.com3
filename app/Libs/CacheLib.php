<?php

namespace App\Libs;

use Illuminate\Support\Facades\Cache;

/**
 * Cacheを操作するライブラリ
 */
class CacheLib
{
    private static $cache_time = 60*90; //90分

    /**
     * キャッシュを取得
     * 
     * @param string $key    キャッシュのキー
     * @param array $query   キーに追加付属させるクエリ
     * @param mixed $default 値が取得できなかったときのデフォルト値
     */
    public static function get(string $key, array $query, $default = null)
    {
        //クエリが与えられたときは、クエリのキーで並び順を揃える
        if (!empty($query)) {
            ksort($query);
        }

        //キャッシュがあるかどうかを判定して返却します
        return Cache::get(
            !empty($query)
                ? $key . "?" . urldecode(http_build_query($query))
                : $key,
            $default,
        );
    }

    /**
     * キャッシュを保存
     * 
     * @param string $key   キャッシュのキー
     * @param mixed $value  保存する値
     * @param array $query  キーに追加付属させるクエリ
     * @param int $time     キャッシュの継続時間
     */
    public static function put(string $key, mixed $value, array $query = [], int $time = null)
    {
        //クエリが与えられたときは、クエリのキーで並び順を揃える
        if (!empty($query)) {
            ksort($query);
        }

        //キャッシュを保存する
        Cache::put(
            !empty($query)
                ? $key . "?" . urldecode(http_build_query($query))
                : $key,
            $value,
            $time ?? self::$cache_time,
        );
    }

    /**
     * キャッシュがなかった場合は作成、あった場合は値を作成する
     * 
     * @param string $key           キャッシュのキー
     * @param \Closure $callback    値を取得するコールバック関数
     * @param array $query          キーに追加付属させるクエリ
     * @param int $time             キャッシュの継続時間
     * 
     * @return mixed
     */
    public static function remember(string $key, \Closure $callback, array $query = [], int $time = null) : mixed
    {
        //クエリが与えられたときは、クエリのキーで並び順を揃える
        if (!empty($query)) {
            ksort($query);
        }

        //キャッシュを取得、または作成する
        $result = Cache::remember(
            !empty($query)
                ? $key . "?" . urldecode(http_build_query($query))
                : $key,
            $time ?? self::$cache_time,
            $callback,
        );
        
        //取得した値を返す
        return $result;
    }

    /**
     * キャッシュが存在するかどうか調べる
     * 
     * @param string $key  キャッシュのキー
     * @param array $query キーに追加付属させるクエリ
     */
    public static function has(string $key, array $query = []) : bool
    {
        //クエリが与えられたときは、クエリのキーで並び順を揃える
        if (!empty($query)) {
            ksort($query);
        }

        //キャッシュがあるかどうかを判定して返却します
        return Cache::has(
            !empty($query)
                ? $key . "?" . urldecode(http_build_query($query))
                : $key
        );
    }
}