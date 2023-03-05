<template>

    <!-- 検索ワード -->
    <RecommendQuery />

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- ゲーム実況ニュース -->
        <H2Title
            id="game-news"
            title_jp="ゲーム実況ニュース"
            link_title="すべてのニュースを見る"
            link_path="/news"
        />
        <DefaultSection>
            <IndexNews />
        </DefaultSection>
        
        <!-- 今週のランキング -->
        <H2Title
            id="game-ranking"
            title_jp="今週の実況動画ランキング"
            link_title="すべてのランキングを見る"
            link_path="/ranking"
        />
        <DefaultSection>
            <IndexRanking />
        </DefaultSection>
        
        <!-- 新着実況プレイ動画 -->
        <H2Title
            id="game-program"
            title_jp="新着実況プレイ動画"
            link_title="すべての動画を見る"
            link_path="/program"
        />
        <DefaultSection>
            <IndexProgram />
        </DefaultSection>
        
        <!-- おすすめ動画レビュー -->
        <H2Title
            id="game-review"
            title_jp="おすすめレビュー動画"
            link_title="すべてのレビュー動画を見る"
            link_path="/review"
        />
        <DefaultSection>
            <IndexReview />
        </DefaultSection>

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
import DefaultSection from "@/js/Components/Section/DefaultSection.vue";
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
        DefaultSection,
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

</style>