<?php

use App\Models\Site;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //データベースの作成
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('動画サイト名');
        });

        //初期データの作成
        Site::create([
            'id'   => config('const.site.youtube'),
            'name' => 'YouTube',
        ]);
        Site::create([
            'id'   => config('const.site.nicovideo'),
            'name' => 'ニコニコ動画',
        ]);
        Site::create([
            'id'   => config('const.site.openrec'),
            'name' => 'OPENREC.tv',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
}
