<template>

    <!-- 検索ワード -->
    <SearchItem />

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- ゲーム実況ニュース -->
        <H2Title
            title_jp="ゲーム実況ニュース"
            title_en="GAME NEWS"
        />
        <section>
            <GameNews />
        </section>
        <hr>
        
        <!-- 今週のランキング -->
        <H2Title
            title_jp="今週の実況動画ランキング"
            title_en="GAME RANKING"
        />
        <section>
            <GameRanking />
        </section>
        <hr>
        
        <!-- 新着実況プレイ動画 -->
        <H2Title
            title_jp="新着実況プレイ動画"
            title_en="GAME MOVIE"
        />
        <section>
            <GameProgram />
        </section>
        <hr>
        
        <!-- おすすめ動画レビュー -->
        <H2Title
            title_jp="おすすめ動画レビュー"
            title_en="GAME REVIEW"
        />
        <section>
            <GameReview />
        </section>
        <hr>

        <!-- 人気の検索ワード -->
        <SearchWord />

    </div>

</template>

<script>
import SearchItem from "./SearchItem.vue";
import SearchWord from "./SearchWord.vue";
import H2Title from "@/js/Components/H2Title.vue";
import GameNews from "./GameNews.vue";
import GameRanking from "./GameRanking.vue";
import GameProgram from "./GameProgram.vue";
import GameReview from "./GameReview.vue";
export default {

    //読み込んだコンポーネント
    components: {
        SearchItem,
        SearchWord,
        H2Title,
        GameNews,
        GameRanking,
        GameProgram,
        GameReview,
    },
};
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    section {
        margin-top: 4px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        @media screen and (min-width: $bp) {
            padding-left: 8px;
        }
    }
    hr {
        margin: 25px 0 30px;
        color: #e5dae1;
    }
</style>