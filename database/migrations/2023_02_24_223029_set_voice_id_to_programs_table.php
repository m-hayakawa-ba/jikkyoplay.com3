<?php

use App\Models\Program;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetVoiceIdToProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //声idを削除する
        Schema::table('creaters', function (Blueprint $table) {
            $table->dropForeign('creaters_voice_id_foreign');
            $table->dropColumn('voice_id');
        });

        //更新フラグを追加
        Schema::table('programs', function (Blueprint $table) {
            $table->boolean('flag_changed')->default(0)->after('flag_enabled')->comment('情報修正済みフラグ');
        });
        
        //女性実況を設定
        Program::join('creaters', 'programs.creater_id', '=', 'creaters.id')
            ->where(function ($q) {
                $q->where('programs.title', 'like', '%女性実況%')
                    ->orWhere('programs.title', 'like', '%女子実況%')
                    ->orWhere('programs.title', 'like', '%女実況%')
                    ->orWhere('programs.title', 'like', '%主婦%')
                    ->orWhere('creaters.name',  'like', '%女性%')
                    ->orWhere('creaters.name',  'like', '%女実況%');
            })
            ->update(['voice_id' => config('const.voice.female')]);

        //男女実況を設定
        Program::where(function ($q) {
                $q->where('title', 'like', '%男女2人%')
                    ->orWhere('title', 'like', '%男女二人%')
                    ->orWhere('title', 'like', '%男女実況%')
                    ->orWhere('title', 'like', '%カップルで%')
                    ->orWhere('title', 'like', '%カップル実況%')
                    ->orWhere('title', 'like', '%カップルゲーム実況%')
                    ->orWhere('title', 'like', '%夫婦で%')
                    ->orWhere('title', 'like', '%夫婦実況%')
                    ->orWhere('title', 'like', '%夫婦ゲーム実況%');
            })
            ->update(['voice_id' => config('const.voice.other')]);
        
        //ゆっくり実況を設定
        Program::where(function ($q) {
            $q->where('title', 'like', '%ゆっくり%')
                ->orWhere('title', 'like', '%VOCALOID実況%')
                ->orWhere('title', 'like', '%VOICEROID実況%');
        })
        ->update(['voice_id' => config('const.voice.vocaloid')]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('flag_changed');
        });

        Schema::table('creaters', function (Blueprint $table) {
            $table->integer('voice_id')->unsigned()->default('1')->after('site_id')->comment('声id');
        });
        Schema::table('creaters', function($table) {
            $table->foreign('voice_id')->references('id')->on('voices')->onDelete('restrict');
        });
    }
}
