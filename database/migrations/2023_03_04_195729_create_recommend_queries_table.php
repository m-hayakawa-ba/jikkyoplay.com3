<?php

use App\Models\RecommendQuery;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendQueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommend_queries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('検索の表示名');
            $table->string('path')->comment('おすすめリンクのパス');
            $table->integer('sort_id')->comment('並び順');
            $table->softDeletes();
        });

        RecommendQuery::create([
            'name'    => '新着動画',
            'path'    => '/program?sort=date&order=desc',
            'sort_id' => 1,
        ]);
        RecommendQuery::create([
            'name'    => '人気の動画',
            'path'    => '/ranking',
            'sort_id' => 2,
        ]);
        RecommendQuery::create([
            'name'    => '女性実況',
            'path'    => '/program?voice_id=2',
            'sort_id' => 3,
        ]);
        RecommendQuery::create([
            'name'    => 'RPG実況',
            'path'    => '/program?word=RPG',
            'sort_id' => 4,
        ]);
        RecommendQuery::create([
            'name'    => 'ホラーゲーム実況',
            'path'    => '/program?word=ホラー',
            'sort_id' => 5,
        ]);
        RecommendQuery::create([
            'name'    => 'レトロゲーム実況',
            'path'    => '/program?retro=1',
            'sort_id' => 6,
        ]);
        RecommendQuery::create([
            'name'    => 'Minecraft',
            'path'    => '/program?word=minecraft',
            'sort_id' => 7,
        ]);
        RecommendQuery::create([
            'name'    => 'Apex',
            'path'    => '/program?word=Apex',
            'sort_id' => 8,
        ]);
        RecommendQuery::create([
            'name'    => 'あつまれ どうぶつの森',
            'path'    => '/program?word=あつまれどうぶつの森',
            'sort_id' => 9,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recommend_queries');
    }
}
