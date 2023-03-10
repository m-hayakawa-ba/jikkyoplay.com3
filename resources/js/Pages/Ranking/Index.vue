<template>

    <!-- タイトル -->
    <Head>
        <title>ゲーム実況動画 人気ランキング｜ゲーム実況動画まとめサイト GameJDM</title>
        <meta name="description" content="ゲームの実況プレイ動画や実況プレイヤーの人気ランキングを、YouTubeやニコニコ動画の再生数をもとにまとめています。" />
        <link rel="canonical" href="https://jikkyoplay.com/ranking">
    </Head>

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- 今週のランキング -->
        <H2Title
            title_jp="今週の実況動画ランキング"
            title_en="GAME RANKING"
        />

        <!-- ランキングの説明 -->
        <div class="page-caption">
            過去1週間に投稿されたゲーム実況動画の再生数をもとにしたランキングです！
        </div>

        <!-- ページ内リンク -->
        <div class="page-anker-wrap">
            <SmoothLink anker="total-ranking" class="page-anker-link">
                <img src="/icon/crown.svg">
                総合ランキング
            </SmoothLink>
            <SmoothLink anker="creater-ranking" class="page-anker-link">
                <img src="/icon/crown.svg">
                人気実況者ランキング
            </SmoothLink>
            <SmoothLink anker="female-ranking" class="page-anker-link">
                <img src="/icon/crown.svg">
                女性実況ランキング
            </SmoothLink>
            <SmoothLink anker="horror-ranking" class="page-anker-link">
                <img src="/icon/crown.svg">
                ホラー実況ランキング
            </SmoothLink>
            <SmoothLink anker="retro-ranking" class="page-anker-link">
                <img src="/icon/crown.svg">
                レトロゲーム実況ランキング
            </SmoothLink>
        </div>
        
        <!-- 総合ランキング -->
        <RankingBanner
            id="total-ranking"
            image_url="/image/banner/ranking_total.jpg"
            title="総合ランキング"
        />
        <DefaultSection>
            <template v-for="(ranking, index) in total_rankings" :key="ranking.id">
                <div v-if="index == 0" class="ranking-first pc-only"></div>
                <div class="ranking-wrap">
                    <ProgramWrap
                        :rank="index + 1"
                        :program="ranking"
                    />   
                </div>
                <div v-if="index == 0" class="ranking-first pc-only"></div>
            </template>
        </DefaultSection>
        
        <!-- 人気実況者ランキング -->
        <RankingBanner
            id="creater-ranking"
            image_url="/image/banner/ranking_creater.jpg"
            title="人気実況者ランキング"
        />
        <DefaultSection>
            <template v-for="(ranking, index) in creater_rankings" :key="ranking.id">
                <div v-if="index == 0" class="ranking-first pc-only"></div>
                <div class="ranking-wrap">
                    <CreaterWrap
                        :rank="index + 1"
                        :creater="ranking"
                    />   
                </div>
                <div v-if="index == 0" class="ranking-first pc-only"></div>
            </template>
        </DefaultSection>
        
        <!-- 女性実況動画ランキング -->
        <RankingBanner
            id="female-ranking"
            image_url="/image/banner/ranking_female.jpg"
            title="女性実況動画ランキング"
        />
        <DefaultSection>
            <template v-for="(ranking, index) in female_rankings" :key="ranking.id">
                <div v-if="index == 0" class="ranking-first pc-only"></div>
                <div class="ranking-wrap">
                    <ProgramWrap
                        :rank="index + 1"
                        :program="ranking"
                    />   
                </div>
                <div v-if="index == 0" class="ranking-first pc-only"></div>
            </template>
        </DefaultSection>
        
        <!-- ホラー実況ランキング -->
        <RankingBanner
            id="horror-ranking"
            image_url="/image/banner/ranking_horror.jpg"
            title="ホラー実況ランキング"
        />
        <DefaultSection>
            <template v-for="(ranking, index) in horror_rankings" :key="ranking.id">
                <div v-if="index == 0" class="ranking-first pc-only"></div>
                <div class="ranking-wrap">
                    <ProgramWrap
                        :rank="index + 1"
                        :program="ranking"
                    />   
                </div>
                <div v-if="index == 0" class="ranking-first pc-only"></div>
            </template>
        </DefaultSection>
        
        <!-- レトロゲーム実況ランキング -->
        <RankingBanner
            id="retro-ranking"
            image_url="/image/banner/ranking_retro.jpg"
            title="レトロゲーム実況ランキング"
        />
        <DefaultSection>
            <template v-for="(ranking, index) in retro_rankings" :key="ranking.id">
                <div v-if="index == 0" class="ranking-first pc-only"></div>
                <div class="ranking-wrap">
                    <ProgramWrap
                        :rank="index + 1"
                        :program="ranking"
                    />   
                </div>
                <div v-if="index == 0" class="ranking-first pc-only"></div>
            </template>
        </DefaultSection>
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
import { Creater } from "../../Interfaces/Creater";
import { SimpleProgram } from "../../Interfaces/Program";

import { defineComponent } from "vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import CreaterWrap from '@/js/Components/Creater/CreaterWrap.vue';
import DefaultSection from "@/js/Components/Section/DefaultSection.vue";
import H2Title from "@/js/Components/H2Title.vue";
import ProgramWrap from '@/js/Components/Program/ProgramWrap.vue';
import RankingBanner from '@/js/Components/Ranking/RankingBanner.vue';
import SmoothLink from "@/js/Components/SmoothLink.vue";
import AnkerLink from "@/js/Components/AnkerLink.vue";

export default defineComponent({

    //読み込んだコンポーネント
    components: {
        Head,
        SmoothLink,
        CreaterWrap,
        DefaultSection,
        H2Title,
        ProgramWrap,
        RankingBanner,
        AnkerLink,
    },

    //コンポーネント内で使用する変数
    data(): {
        anker:            AnkerData[],
        total_rankings:   SimpleProgram[],
        creater_rankings: Creater[],
        female_rankings:  SimpleProgram[],
        horror_rankings:  SimpleProgram[],
        retro_rankings:   SimpleProgram[],
    } {
        return {
            anker: [],
            total_rankings:   usePage().props.value.total_rankings   as SimpleProgram[],
            creater_rankings: usePage().props.value.creater_rankings as Creater[],
            female_rankings:  usePage().props.value.female_rankings  as SimpleProgram[],
            horror_rankings:  usePage().props.value.horror_rankings  as SimpleProgram[],
            retro_rankings:   usePage().props.value.retro_rankings   as SimpleProgram[],
        };
    },

    //初回読み込み時に実行
    mounted() {
        
        //スクロール用のidの位置を設定
        this.anker = [
            {name: 'トップ',     id: "app",             pos: 0},
            {name: '総合',       id: "total-ranking",   pos: 0},
            {name: '人気実況者', id: "creater-ranking", pos: 0},
            {name: '女性実況',   id: "female-ranking",  pos: 0},
            {name: 'ホラー実況', id: "horror-ranking",  pos: 0},
            {name: 'レトロゲー', id: "retro-ranking",   pos: 0},
        ];
    }
});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .page-caption {
        margin: 10px 0 5px;
        @media screen and (min-width: $bp) {
            margin-left: 16px;
        }
    }
    .page-anker-wrap {
        max-width: 480px;
        margin: 40px auto 40px;
        padding: 8px;
        font-size: $font-l;
        text-align: center;
    }
    .page-anker-link {
        display: block;
        margin: 12px 0;
        padding: 4px 0;
        border: solid 1px #7e7563;
        border-radius: 4px;
        box-shadow: 1px 1px 2px #9f78605c;
        color: #381b06;
        img {
            position: relative;
            top: 2px;
            display: inline;
            width: 20px;
        }
    }
    .ranking-wrap {
        position: relative;
        margin-bottom: 12px;
        width: 100%;
        @media screen and (min-width: $bp) {
            margin: 0 0.166% 24px;
            width: 33%;
            &:nth-child(2) {
                width: 45%;
            }
        }
    }
    .ranking-first {
        width: 27%;
    }

</style>