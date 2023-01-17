<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Libs\GoogleNewsLib;
use App\Services\News\NewsCreateService;

/**
 * googleニュースを取得してデータベースに保存するコマンド
 */
class GetNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:news {after?} {before?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve news about live games from google news and store it in the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        private NewsCreateService $newsCreateService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //取得開始日時
        $start_on = $this->argument('after')  ?? date('Y-m-d', strtotime('-1 month'));
        $end_on   = $this->argument('before') ?? date('Y-m-d');

        //ログに出力
        Log::info("ゲーム実況ニュースの取得を開始します。$start_on から $end_on まで");

        //GoogleNewsを取得する
        $str = GoogleNewsLib::getNews($start_on, $end_on);
        if (is_null($str)) {
            return 0;
        }

        //取得したxmlをオブジェクトに変換する
        $obj = simplexml_load_string($str);

        //取得したニュースをDBに保存
        foreach($obj->channel->item as $item) {
            $result = $this->newsCreateService->createNews(
                (string)$item->title,
                (string)$item->pubDate,
                (string)$item->link,
            );
            if (!is_null($result)) {
                //エラー分の出力は特に必要なし
                // dump((string)$result);
                // dump('  ' . (string)$item->title);
            }
        }

        //終了
        Log::info("ゲーム実況ニュースの取得を終了します。");
        return 0;
    }
}
