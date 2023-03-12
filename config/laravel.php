<?php

//Laravel側のみで使う定数ファイルです
return [

    //js・cssのバージョン
    'version' => 26,

    //トップページの表示数・表示期間
    'max_news_count'        => 6,           //トップページに表示させるニュースの表示数
    'max_ranking_count'     => 3,           //トップページに表示させるランキングの数
    'period_ranking'        => '-1 week',   //トップページに表示させるランキングの集計期間
    'max_program_count'     => 3,           //トップページに表示させるサイトごとの新着動画の数
    'max_review_count'      => 2,           //トップページに表示させるレビューの数
    'max_search_word'       => 20,          //トップページに表示させる検索ワードの数
    'period_search_word'    => '-1 week',   //トップページに表示させる検索ワードの集計期間

    //ランキングの取得数
    'ranking_count'         => 10,          //ランキングページに表示させるランキングの数
    'ranking_period'        => '-1 week',   //ランキングページに表示させるランキングの集計期間

    //動画の取得数
    'program_count'         => 24,          //動画一覧ページに表示させる動画の数
];