<template>

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- 今週のランキング -->
        <H2Title
            title_jp="今週の実況動画ランキング"
            title_en="GAME RANKING"
        />

        <!-- ランキングの説明 -->
        <div>
            1週間以内に投稿されたゲーム実況動画の視聴回数順ランキングです！
        </div>
        
        <!-- ランキング一覧 -->
        <section>
            <div
                v-for="(ranking, index) in total_rankings"
                class="ranking-wrap"
            >
                <ProgramPart
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
import ProgramPart from '@/js/Components/ProgramPart/ProgramWrap.vue';
export default {

    //読み込んだコンポーネント
    components: {
        H2Title,
        ProgramPart,
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
    .ranking-wrap {
        position: relative;
        margin: 8px 0 0;
        width: 100%;
        @media screen and (min-width: $bp) {
            width: 49%;
        }
    }

</style>