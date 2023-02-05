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
            <a href="#total-ranking" class="page-anker-link">
                <img src="/icon/crown.svg">
                総合ランキング
            </a>
            <a href="#creater-ranking" class="page-anker-link">
                <img src="/icon/crown.svg">
                実況者ランキング
            </a>
            <a href="#male-ranking" class="page-anker-link">
                <img src="/icon/crown.svg">
                男性実況動画ランキング
            </a>
            <a href="#female-ranking" class="page-anker-link">
                <img src="/icon/crown.svg">
                女性実況動画ランキング
            </a>
            <a href="#horror-ranking" class="page-anker-link">
                <img src="/icon/crown.svg">
                ホラー実況ランキング
            </a>
            <a href="#retro-ranking" class="page-anker-link">
                <img src="/icon/crown.svg">
                レトロゲーム実況ランキング
            </a>
        </div>
        
        <!-- ランキング一覧 -->
        <section>
            <RankingBanner
                image_url="/image/banner/ranking_female.jpg"
                title="女性実況動画ランキング"
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

    </div>
</template>

<script>
import {usePage} from "@inertiajs/inertia-vue3";
import H2Title from "@/js/Components/H2Title.vue";
import ProgramWrap from '@/js/Components/Program/ProgramWrap.vue';
import RankingBanner from '@/js/Components/Ranking/RankingBanner.vue';
export default {

    //読み込んだコンポーネント
    components: {
        H2Title,
        ProgramWrap,
        RankingBanner,
    },

    //コンポーネント内で使用する変数
    data() {
        return {
            total_rankings:   usePage().props.value.total_rankings,
            creater_rankings: usePage().props.value.creater_rankings,
            male_rankings:    usePage().props.value.male_rankings,
            female_rankings:  usePage().props.value.female_rankings,
            horror_rankings:  usePage().props.value.horror_rankings,
            retro_rankings:   usePage().props.value.retro_rankings,
        };
    },

    //初回読み込み時に実行
    mounted() {
        console.log(this.retro_rankings);
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
    .page-caption {
        margin: 10px 0 5px;
    }
    .page-anker-wrap {
        max-width: 480px;
        margin: 0 auto 20px;
        padding: 8px;
        font-size: $font-l;
        text-align: center;
    }
    .page-anker-link {
        display: block;
        margin: 6px;
        img {
            width: 16px;
            display: inline;
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