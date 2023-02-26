<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fix_program_infomations', function (Blueprint $table) {
            $table->string('old_game_id')->nullable(true)->default(null)->change();
            $table->string('old_voice_id')->nullable(true)->default(null)->change();
            $table->string('new_game_id')->nullable(true)->default(null)->change();
            $table->string('new_voice_id')->nullable(true)->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fix_program_infomations', function (Blueprint $table) {
            $table->string('old_game_id')->nullable(false)->change();
            $table->string('old_voice_id')->nullable(false)->change();
            $table->string('new_game_id')->nullable(false)->change();
            $table->string('new_voice_id')->nullable(false)->change();
        });
    }
}
