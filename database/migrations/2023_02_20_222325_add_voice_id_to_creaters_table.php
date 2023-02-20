<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVoiceIdToCreatersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('creaters', function (Blueprint $table) {
            $table->integer('voice_id')->unsigned()->default('1')->after('site_id')->comment('声id');
        });

        //外部キー制約
        Schema::table('creaters', function($table) {
            $table->foreign('voice_id')->references('id')->on('voices')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('creaters', function (Blueprint $table) {
            $table->dropForeign('creaters_voice_id_foreign');
            $table->dropColumn('voice_id');
        });
    }
}
