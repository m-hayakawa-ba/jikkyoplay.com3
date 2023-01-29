<?php
return [

    'site_title' => env('APP_NAME', 'Laravel'),

    'url' => [
        'official_twitter' => 'https://twitter.com/jikkyoplay',
    ],

    //動画サイトの種類
    'site' => [
        'youtube' => 1,
        'nicovideo' => 2,
        'openrec' => 3,
    ],

    //動画の音声の種類
    'voice' => [
        'male'     => 1,
        'female'   => 2,
        'vocaloid' => 3,
        'other'    => 4,
        'none'     => 5,
    ],
];