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

        <!-- 人気の検索ワード -->
        <SearchWord />

    </div>

</template>

<script>
import SearchItem from "./SearchItem.vue";
import SearchWord from "./SearchWord.vue";
import GameNews from "./GameNews.vue";
import GameRanking from "./GameRanking.vue";
import GameProgram from "./GameProgram.vue";
import GameReview from "./GameReview.vue";
export default {

    //読み込んだコンポーネント
    components: {
        SearchItem,
        SearchWord,
        GameNews,
        GameRanking,
        GameProgram,
        GameReview,
    },
};
</script>


<style lang="scss" scoped>
@import "@/sass/variables";

</style>