<template>

    <!-- 検索ワード -->
    <RecommendQuery />

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- ゲーム実況ニュース -->
        <H2Title
            id="game-news"
            title_jp="ゲーム実況ニュース"
            title_en="GAME NEWS"
        />
        <PageLink
            href="/news"
            link_name="すべてのニュース"
        />
        <section>
            <IndexNews />
        </section>
        <hr>
        
        <!-- 今週のランキング -->
        <H2Title
            id="game-ranking"
            title_jp="今週の実況動画ランキング"
            title_en="GAME RANKING"
        />
        <PageLink
            href="/ranking"
            link_name="すべてのランキング"
        />
        <section>
            <IndexRanking />
        </section>
        <hr>
        
        <!-- 新着実況プレイ動画 -->
        <H2Title
            id="game-program"
            title_jp="新着実況プレイ動画"
            title_en="GAME MOVIE"
        />
        <PageLink
            href="/program"
            link_name="すべての動画を見る"
        />
        <section>
            <IndexProgram />
        </section>
        <hr>
        
        <!-- おすすめ動画レビュー -->
        <H2Title
            id="game-review"
            title_jp="おすすめ動画レビュー"
            title_en="GAME REVIEW"
        />
        <PageLink
            href="/review"
            link_name="すべてのレビューを見る"
        />
        <section>
            <IndexReview />
        </section>
        <hr>

        <!-- 人気の検索ワード -->
        <SearchWord
            id="game-word"
        />
    </div>

    <!-- アンカーリンク -->
    <AnkerLink
        v-if="anker.length > 0"
        :anker="anker"
        mode="prev"
    />
    <AnkerLink
        v-if="anker.length > 0"
        :anker="anker"
        mode="next"
    />

</template>

<script lang="ts">
import { AnkerData } from "../../Interfaces/AnkerData";
import { defineComponent } from "vue";
import RecommendQuery from "./RecommendQuery.vue";
import SearchWord from "./SearchWord.vue";
import H2Title   from "@/js/Components/H2Title.vue";
import AnkerLink from "@/js/Components/AnkerLink.vue";
import PageLink from '@/js/Components/PageLink.vue';
import IndexNews from "./Index__News.vue";
import IndexRanking from "./Index__Ranking.vue";
import IndexProgram from "./Index__Program.vue";
import IndexReview from "./Index__Review.vue";

export default defineComponent({

    //読み込んだコンポーネント
    components: {
        RecommendQuery,
        SearchWord,
        H2Title,
        AnkerLink,
        PageLink,
        IndexNews,
        IndexRanking,
        IndexProgram,
        IndexReview,
    },

    //コンポーネント内で使用する変数
    data(): {
        anker: AnkerData[]
    } {
        return {
            anker: [],
        };
    },

    //初回読み込み時に実行
    mounted() {
        
        //スクロール用のidの位置を設定
        this.anker = [
            {name: 'トップ',     id: "app",          pos: 0},
            {name: 'ニュース',   id: "game-news",    pos: 0},
            {name: 'ランキング', id: "game-ranking", pos: 0},
            {name: '新着動画',   id: "game-program", pos: 0},
            {name: 'レビュー',   id: "game-review",  pos: 0},
        ];
    }
});
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