<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->foreignId('news_source_id')->after('title')->comment('ニュースソースid')->constrained();
            $table->string('image_url')->nullable()->after('url')->comment('ニュースの画像url');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex('news_published_at_index');
            $table->dropForeign('news_news_source_id_foreign');
            $table->dropColumn('news_source_id');
            $table->dropColumn('image_url');
        });
    }
}
