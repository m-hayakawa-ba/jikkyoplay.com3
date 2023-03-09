<template>

    <!-- タイトル -->
    <Head>
        <title>ゲーム実況動画まとめサイト GameJDM</title>
    </Head>

    <!-- サイト本体部分 -->
    <div class="inner">

        <!-- 検索ワード -->
        <div class="search-item-wrap">
            <LinkTag
                v-for="recommend_query in recommend_queries"
                :key="recommend_query.id"
                :name="recommend_query.name"
                :link="recommend_query.path"
                icon="single_right"
            />
        </div>
        
        <!-- ゲーム実況ニュース -->
        <H2Title
            id="game-news"
            title_jp="ゲーム実況ニュース"
            link_title="すべてのニュースを見る"
            link_path="/news"
        />
        <DefaultSection>
            <IndexNews />
            <PageLink
                link_name="すべてのニュースを見る"
                href="/news"
            />
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
            <PageLink
                link_name="すべてのランキングを見る"
                href="/ranking"
            />
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
            <PageLink
                link_name="すべての動画を見る"
                href="/program"
            />
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
            <PageLink
                link_name="すべてのレビュー動画を見る"
                href="/review"
            />
        </DefaultSection>

        <!-- 人気の検索ワード -->
        <H2Title
            id="game-search"
            title_jp="人気の検索ワード"
        />
        <section class="search-word-wrap">
            <LinkTag
                v-for="search_word in search_words"
                :key="search_word.id"
                :name="search_word.word"
                :link="'/program?word=' + search_word.word"
                icon="single_right"
            />
        </section>
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
import DefaultSection from "@/js/Components/Section/DefaultSection.vue";

import { AnkerData } from "../../Interfaces/AnkerData";
import { RecommendQuery } from '../../Interfaces/RecommendQuery'
import { SearchWord } from "../../Interfaces/SearchWord";

import { defineComponent } from "vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import H2Title   from "@/js/Components/H2Title.vue";
import LinkTag   from "@/js/Components/LinkTag.vue";
import AnkerLink from "@/js/Components/AnkerLink.vue";
import PageLink from '@/js/Components/PageLink.vue';
import IndexNews from "./Index__News.vue";
import IndexRanking from "./Index__Ranking.vue";
import IndexProgram from "./Index__Program.vue";
import IndexReview from "./Index__Review.vue";

export default defineComponent({

    //読み込んだコンポーネント
    components: {
        H2Title,
        LinkTag,
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
        anker: AnkerData[],
        recommend_queries: RecommendQuery[],
        search_words: SearchWord[]
    } {
        return {
            anker: [],
            recommend_queries: usePage().props.value.recommend_queries as RecommendQuery[],
            search_words: usePage().props.value.search_words as SearchWord[],
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
            {name: '検索ワード', id: "game-search",  pos: 0},
        ];
    }
});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .search-item-wrap {
        margin: 0 auto;
        padding: 15px 0px 10px;
        width: 100%;
        text-align: center;
        white-space: nowrap;
        overflow-x: scroll;
        scrollbar-width: none;
        &::-webkit-scrollbar{
            display:none;
        }
        @media screen and (min-width: $bp) {
            padding: 30px 0px 30px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 40px 0px 30px;
        }
    }
    .search-word-wrap {
        margin: 40px 0 60px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
</style>