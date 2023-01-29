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

    //ゲームハード
    'hard' => [
        'famicom'           => 1,
        'disk_system'       => 2,
        'super_famicon'     => 3,
        
        'mega_drive'        => 19,

        'pc_engine'         => 22,

        'game_boy'          => 31,
        'game_boy_color'    => 32,
        'virtual_boy'       => 33,
        'game_boy_advance'  => 34,

        'wonder_swan'       => 39,
        'game_gear'         => 40,
    ],
];