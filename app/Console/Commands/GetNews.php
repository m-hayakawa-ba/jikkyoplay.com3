<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
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
        //GoogleNewsを取得する
        $str = GoogleNewsLib::getNews(
            $this->argument('after')  ?? date('Y-m-d', strtotime('-3 day')),
            $this->argument('before') ?? date('Y-m-d'),
        );
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
                dump((string)$result);
                dump('  ' . (string)$item->title);
            }
        }
        return 0;
    }
}
