<template>

    <!-- 検索ワード -->
    <SearchItem />

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- ゲーム実況ニュース -->
        <GameNews />
        
        <!-- 今週のランキング -->
        <GameRanking />
        
        <!-- 新着実況プレイ動画 -->
        <GameProgram />
        
        <!-- おすすめ動画レビュー -->
        <GameReview />

    </div>

</template>

<script>
import SearchItem from "./SearchItem.vue";
import GameNews from "./GameNews.vue";
import GameRanking from "./GameRanking.vue";
import GameProgram from "./GameProgram.vue";
import GameReview from "./GameReview.vue";
export default {

    //読み込んだコンポーネント
    components: {
        SearchItem,
        GameNews,
        GameRanking,
        GameProgram,
        GameReview,
    },
};
</script>