<template>

    <!-- 検索ワード -->
    <SearchItem />

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- ゲーム実況ニュース -->
        <H2Title
            id="game-news"
            title_jp="ゲーム実況ニュース"
            title_en="GAME NEWS"
        />
        <section>
            <GameNews />
        </section>
        <hr>
        
        <!-- 今週のランキング -->
        <H2Title
            id="game-ranking"
            title_jp="今週の実況動画ランキング"
            title_en="GAME RANKING"
        />
        <section>
            <GameRanking />
        </section>
        <hr>
        
        <!-- 新着実況プレイ動画 -->
        <H2Title
            id="game-program"
            title_jp="新着実況プレイ動画"
            title_en="GAME MOVIE"
        />
        <section>
            <GameProgram />
        </section>
        <hr>
        
        <!-- おすすめ動画レビュー -->
        <H2Title
            id="game-review"
            title_jp="おすすめ動画レビュー"
            title_en="GAME REVIEW"
        />
        <section>
            <GameReview />
        </section>
        <hr>

        <!-- 人気の検索ワード -->
        <SearchWord
            id="game-word"
        />
    </div>

    <!-- アンカーリンク -->
    <AnkerLink
        v-if="anker"
        :anker="anker"
        mode="prev"
    />
    <AnkerLink
        v-if="anker"
        :anker="anker"
        mode="next"
    />

</template>

<script>
import SearchItem from "./SearchItem.vue";
import SearchWord from "./SearchWord.vue";
import H2Title   from "@/js/Components/H2Title.vue";
import AnkerLink from "@/js/Components/AnkerLink.vue";
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
        AnkerLink,
        GameNews,
        GameRanking,
        GameProgram,
        GameReview,
    },

    //コンポーネント内で使用する変数
    data() {
        return {
            anker: null,
        };
    },

    //初回読み込み時に実行
    mounted() {
        
        //スクロール用のidの位置を取得
        this.anker = [
            {name: 'トップ',     id: "app",          pos: 0},
            {name: 'ニュース',   id: "game-news",    pos: 0},
            {name: 'ランキング', id: "game-ranking", pos: 0},
            {name: '新着動画',   id: "game-program", pos: 0},
            {name: 'レビュー',   id: "game-review",  pos: 0},
            {name: '検索ワード', id: "game-word",    pos: 0},
        ];

        console.log(this.anker);
    }
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