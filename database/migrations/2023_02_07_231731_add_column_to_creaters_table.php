<?php

use App\Models\Creater;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCreatersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //カラムの追加
        Schema::table('creaters', function (Blueprint $table) {
            $table->foreignId('site_id')->default('1')->after('name')->comment('サイトid')->constrained();
        });

        //user_idの文字列の長さが10文字以下のとき、ニコニコ動画のユーザーだとみなす
        Creater::whereRaw('LENGTH(user_id) <= 10')
            ->update(['site_id' => 2]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('creaters', function (Blueprint $table) {
            $table->dropForeign('creaters_site_id_foreign');
            $table->dropColumn('site_id');
        });
    }
}
