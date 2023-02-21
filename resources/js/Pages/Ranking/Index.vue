<template>

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
        <section id="total-ranking">

            <RankingBanner
                image_url="/image/banner/ranking_total.jpg"
                title="総合ランキング"
            />
            <div
                v-for="(ranking, index) in total_rankings"
                class="ranking-wrap"
            >
                <ProgramWrap
                    :rank="index + 1"
                    :program="ranking"
                />   
            </div>
        </section>
        
        <!-- 人気実況者ランキング -->
        <section id="creater-ranking">

            <RankingBanner
                image_url="/image/banner/ranking_creater.jpg"
                title="人気実況者ランキング"
            />
            <div
                v-for="(ranking, index) in creater_rankings"
                class="ranking-wrap"
            >
                <CreaterWrap
                    :rank="index + 1"
                    :creater="ranking"
                />   
            </div>
        </section>
        
        <!-- 女性実況動画ランキング -->
        <section id="female-ranking">

            <RankingBanner
                image_url="/image/banner/ranking_female.jpg"
                title="女性実況動画ランキング"
            />
            <div
                v-for="(ranking, index) in female_rankings"
                class="ranking-wrap"
            >
                <ProgramWrap
                    :rank="index + 1"
                    :program="ranking"
                />   
            </div>
        </section>
        
        <!-- ホラー実況ランキング -->
        <section id="horror-ranking">

            <RankingBanner
                image_url="/image/banner/ranking_horror.jpg"
                title="ホラー実況ランキング"
            />
            <div
                v-for="(ranking, index) in horror_rankings"
                class="ranking-wrap"
            >
                <ProgramWrap
                    :rank="index + 1"
                    :program="ranking"
                />   
            </div>
        </section>
        
        <!-- レトロゲーム実況ランキング -->
        <section id="retro-ranking">

            <RankingBanner
                image_url="/image/banner/ranking_retro.jpg"
                title="レトロゲーム実況ランキング"
            />
            <div
                v-for="(ranking, index) in retro_rankings"
                class="ranking-wrap"
            >
                <ProgramWrap
                    :rank="index + 1"
                    :program="ranking"
                />   
            </div>
        </section>
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
import {usePage} from "@inertiajs/inertia-vue3";
import H2Title from "@/js/Components/H2Title.vue";
import SmoothLink from "@/js/Components/SmoothLink.vue";
import ProgramWrap from '@/js/Components/Program/ProgramWrap.vue';
import CreaterWrap from '@/js/Components/Creater/CreaterWrap.vue';
import RankingBanner from '@/js/Components/Ranking/RankingBanner.vue';
import AnkerLink from "@/js/Components/AnkerLink.vue";
export default {

    //読み込んだコンポーネント
    components: {
        H2Title,
        SmoothLink,
        ProgramWrap,
        CreaterWrap,
        RankingBanner,
        AnkerLink,
    },

    //コンポーネント内で使用する変数
    data() {
        return {
            total_rankings:   usePage().props.value.total_rankings,
            creater_rankings: usePage().props.value.creater_rankings,
            female_rankings:  usePage().props.value.female_rankings,
            horror_rankings:  usePage().props.value.horror_rankings,
            retro_rankings:   usePage().props.value.retro_rankings,
            anker: null,
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
};
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    section {
        margin-bottom: 60px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        @media screen and (min-width: $bp) {
            padding-left: 8px;
        }
    }
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
        margin: 8px 0 0;
        width: 100%;
        @media screen and (min-width: $bp) {
            width: 49%;
        }
    }

</style>